<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityGroup;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Get all community groups
     */
    public function getGroups(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'nullable|exists:community_categories,id',
            'search' => 'nullable|string|max:100',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        $query = CommunityGroup::with(['category:id,name,color,icon','admin:id,name,email,avatar'])
            ->withCount(['members', 'posts'])
            ->where('is_active', true);

        // Filter by category
        if ($request->category_id) {
            $query->where('community_category_id', $request->category_id);
        }

        // Search by name or description
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $groups = $query->orderBy('members_count', 'desc')
            ->paginate($perPage);

        // Add user membership status
        $groups->getCollection()->transform(function ($group) use ($userId) {
            $membership = $group->members()->where('user_id', $userId)->first();
            $group->user_is_member = $membership !== null;
            $group->user_role = $membership ? $membership->role : null;
            return $group;
        });

        return response()->json([
            'success' => true,
            'data' => $groups,
        ]);
    }

    /**
     * Get specific banner by ID
     */
    public function getGroupById($id): JsonResponse
    {
        try {

            $userId = auth()->id();
            $perPage = $request->per_page ?? 20;

            $query = CommunityGroup::with(['category:id,name,color,icon','admin:id,name,email,avatar'])
                ->withCount(['members', 'posts'])
                ->where('id', $id)
                ->where('is_active', true);

            $groups = $query->orderBy('members_count', 'desc')
                ->paginate($perPage);

            // Add user membership status
            $groups->getCollection()->transform(function ($group) use ($userId) {
                $membership = $group->members()->where('user_id', $userId)->first();
                $group->user_is_member = $membership !== null;
                $group->user_role = $membership ? $membership->role : null;
                return $group;
            });

            return response()->json([
                'success' => true,
                'data' => $groups,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch banner',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific group details
     */
    public function getGroup($groupId): JsonResponse
    {
        $group = CommunityGroup::with(['category:id,name,color,icon'])
            ->withCount(['members', 'posts'])
            ->findOrFail($groupId);

        if (!$group->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Group is not active',
            ], 404);
        }

        $userId = auth()->id();
        $membership = $group->members()->where('user_id', $userId)->first();

        $groupData = $group->toArray();
        $groupData['user_is_member'] = $membership !== null;
        $groupData['user_role'] = $membership ? $membership->role : null;
        $groupData['can_post'] = $membership !== null; // Only members can post

        return response()->json([
            'success' => true,
            'data' => $groupData,
        ]);
    }

    /**
     * Search and filter groups
     */
    public function searchGroups(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'search' => 'nullable|in:paid,free,cant_join',
            ]);

            $userId = auth()->id();
            $perPage = $request->per_page ?? 20;

            $query = CommunityGroup::with(['category:id,name,color,icon'])
                ->withCount(['members', 'posts'])
                ->where('is_active', true);

            $query = CommunityGroup::with(['category:id,name,color,icon'])
                ->withCount(['members', 'posts']);

            // Search by type
            if ($request->search && $request->search == 'free') {
                $query->where('join_type', 'open');
            }

            if ($request->search && $request->search == 'paid') {
                $query->where('join_type', 'approval_required');
            }

            if ($request->search && $request->search == 'cant_join') {
                $query->where('join_type', 'invite_only');
            }

            $groups = $query->orderBy('members_count', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $groups,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Join a group
     */
    public function joinGroup($groupId): JsonResponse
    {
        $group = CommunityGroup::findOrFail($groupId);
        $userId = auth()->id();

        if (!$group->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Group is not active',
            ], 400);
        }

        // Check if already a member
        $existingMembership = $group->members()->where('user_id', $userId)->first();
        if ($existingMembership) {
            return response()->json([
                'success' => false,
                'message' => 'You are already a member of this group',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Add user as member
            GroupMember::create([
                'community_group_id' => $groupId,
                'user_id' => $userId,
                'role' => 'member',
                'joined_at' => now(),
            ]);

            // Increment group member count
            $group->increment('members_count');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully joined the group',
                'data' => [
                    'group_id' => $groupId,
                    'user_role' => 'member',
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to join group',
            ], 500);
        }
    }

    /**
     * Leave a group
     */
    public function leaveGroup($groupId): JsonResponse
    {
        $group = CommunityGroup::findOrFail($groupId);
        $userId = auth()->id();

        $membership = $group->members()->where('user_id', $userId)->first();

        if (!$membership) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a member of this group',
            ], 400);
        }

        // Prevent admin from leaving (they need to transfer ownership first)
        if ($membership->role === 'admin' && $group->members()->where('role', 'admin')->count() === 1) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot leave the group as the only admin. Transfer ownership first.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Remove membership
            $membership->delete();

            // Decrement group member count
            $group->decrement('members_count');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully left the group',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to leave group',
            ], 500);
        }
    }

    /**
     * Get group members
     */
    public function getMembers(Request $request, $groupId): JsonResponse
    {
        $request->validate([
            'role' => 'nullable|in:admin,moderator,member',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $group = CommunityGroup::findOrFail($groupId);
        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        // Check if user is a member
        $userMembership = $group->members()->where('user_id', $userId)->first();
        if (!$userMembership) {
            return response()->json([
                'success' => false,
                'message' => 'You must be a member to view group members',
            ], 403);
        }

        $query = $group->members()
            ->with(['user:id,name,avatar'])
            ->orderByRaw("FIELD(role, 'admin', 'moderator', 'member')")
            ->orderBy('joined_at');

        // Filter by role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        $members = $query->paginate($perPage);

        // Add user's permission to manage each member
        $members->getCollection()->transform(function ($member) use ($userMembership) {
            $member->can_manage = $this->canManageMember($userMembership->role, $member->role);
            return $member;
        });

        return response()->json([
            'success' => true,
            'data' => $members,
        ]);
    }

    /**
     * Update member role
     */
    public function updateMemberRole(Request $request, $groupId, $userId): JsonResponse
    {
        $request->validate([
            'role' => 'required|in:admin,moderator,member',
        ]);

        $group = CommunityGroup::findOrFail($groupId);
        $currentUserId = auth()->id();

        // Get current user's membership
        $currentUserMembership = $group->members()->where('user_id', $currentUserId)->first();
        if (!$currentUserMembership) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a member of this group',
            ], 403);
        }

        // Only admins and moderators can update roles
        if (!in_array($currentUserMembership->role, ['admin', 'moderator'])) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to update member roles',
            ], 403);
        }

        // Get target member
        $targetMembership = $group->members()->where('user_id', $userId)->first();
        if (!$targetMembership) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a member of this group',
            ], 404);
        }

        // Check if current user can manage target member
        if (!$this->canManageMember($currentUserMembership->role, $targetMembership->role)) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot manage this member',
            ], 403);
        }

        // Prevent moderators from promoting to admin or managing other admins
        if ($currentUserMembership->role === 'moderator' && 
            ($request->role === 'admin' || $targetMembership->role === 'admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Moderators cannot manage admin roles',
            ], 403);
        }

        $targetMembership->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Member role updated successfully',
            'data' => $targetMembership->fresh(),
        ]);
    }

    /**
     * Remove member from group
     */
    public function removeMember($groupId, $userId): JsonResponse
    {
        $group = CommunityGroup::findOrFail($groupId);
        $currentUserId = auth()->id();

        // Get current user's membership
        $currentUserMembership = $group->members()->where('user_id', $currentUserId)->first();
        
        if (!$currentUserMembership) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a member of this group',
            ], 403);
        }

        // Only admins and moderators can remove members
        if (!in_array($currentUserMembership->role, ['admin', 'moderator']) && $currentUserId != $userId) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to remove members',
            ], 403);
        }

        // Get target member
        $targetMembership = $group->members()->where('user_id', $userId)->first();
        if (!$targetMembership) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a member of this group',
            ], 404);
        }

        // Check if current user can manage target member
        // if (!$this->canManageMember($currentUserMembership->role, $targetMembership->role)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'You cannot remove this member',
        //     ], 403);
        // }

        // Prevent removing the last admin
        if ($targetMembership->role === 'admin' && 
            $group->members()->where('role', 'admin')->count() === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot remove the last admin. Transfer ownership first.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $targetMembership->delete();
            $group->decrement('members_count');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Member removed successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove member',
            ], 500);
        }
    }

    /**
     * Check if user can manage another member based on roles
     */
    private function canManageMember(string $userRole, string $targetRole): bool
    {
        $roleHierarchy = ['admin' => 3, 'moderator' => 2, 'member' => 1];
        
        return $roleHierarchy[$userRole] > $roleHierarchy[$targetRole];
    }
} 