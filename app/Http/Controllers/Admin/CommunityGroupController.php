<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityGroup;
use App\Models\CommunityCategory;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CommunityGroupController extends Controller
{
    /**
     * Display listing of groups
     */
    public function index(Request $request)
    {
        $query = CommunityGroup::with(['category:id,name,color'])
            ->withCount(['members', 'posts']);

        // Filter by category
        if ($request->category_id) {
            $query->where('community_category_id', $request->category_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $groups = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = CommunityCategory::where('is_active', true)->get(['id', 'name']);

        return view('admin.community.groups.index', compact('groups', 'categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = CommunityCategory::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name']);
        $users = User::role('user')->orderBy('name')->get();

        return view('admin.community.groups.create', compact('categories', 'users'));
    }

    /**
     * Store new group
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:community_groups',
            'description' => 'required|string|max:1000',
            'rules' => 'required|string|max:1000',
            'tags' => 'required|string|max:1000',
            'community_category_id' => 'required|exists:community_categories,id',
            'cover_image' => 'nullable|image|max:2048',
            'admin_user_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        try {
            $coverImagePath = null;
            if ($request->hasFile('cover_image')) {
                $coverImagePath = $request->file('cover_image')
                    ->store('community/groups', 'public');
            }

            $group = CommunityGroup::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'rules' => $request->rules,
                'tags' => $request->tags,
                'community_category_id' => $request->community_category_id,
                'admin_user_id' => $request->admin_user_id,
                'cover_image' => $coverImagePath,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // ✅ Insert admin into group_members if admin_user_id exists
            if ($request->filled('admin_user_id')) {
                \DB::table('group_members')->insert([
                    'group_id' => $group->id,
                    'community_group_id' => $group->id, // adjust if this should be different
                    'user_id' => $request->admin_user_id,
                    'role' => 'admin',
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->route('admin.community.groups.index')
                ->with('success', 'Group created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating group: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display group details
     */
    public function show(CommunityGroup $group)
    {
        $group->load([
            'category:id,name,color',
            'creator:id,name,email',
            'members' => function($query) {
                $query->with('user:id,name,email,avatar')
                      ->orderByRaw("FIELD(role, 'admin', 'moderator', 'member')")
                      ->orderBy('joined_at', 'desc')
                      ->take(20);
            },
            'posts' => function($query) {
                $query->with('user:id,name,avatar')
                      ->latest()
                      ->take(10);
            }
        ]);

        $stats = [
            'total_members' => $group->members()->count(),
            'total_posts' => $group->posts()->count(),
            'posts_this_month' => $group->posts()
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
            'new_members_this_month' => $group->members()
                ->where('joined_at', '>=', now()->startOfMonth())
                ->count(),
            'admins_count' => $group->members()->where('role', 'admin')->count(),
            'moderators_count' => $group->members()->where('role', 'moderator')->count(),
        ];

        return view('admin.community.groups.show', compact('group', 'stats'));
    }

    /**
     * Show edit form
     */
    public function edit(CommunityGroup $group)
    {
        $categories = CommunityCategory::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name']);
        $users = User::role('user')->orderBy('name')->get();

        // get assigned users (pivot relation)
        $users = User::role('user')->orderBy('name')->get();
        
        return view('admin.community.groups.edit', compact('group', 'categories', 'users'));
    }

    /**
     * Update group
     */
    public function update(Request $request, CommunityGroup $group)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:community_groups,name,' . $group->id,
            'description' => 'required|string|max:1000',
            'rules' => 'required|string|max:1000',
            'tags' => 'required|string|max:1000',
            'community_category_id' => 'required|exists:community_categories,id',
            'admin_user_id' => 'nullable|exists:users,id',
            'cover_image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_private' => 'boolean',
            'rules' => 'nullable|string|max:2000',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'rules' => $request->rules,
                'tags' => $request->tags,
                'community_category_id' => $request->community_category_id,
                'admin_user_id' => $request->admin_user_id, // ✅ store admin user
                'is_active' => $request->boolean('is_active', true),
                'is_private' => $request->boolean('is_private', false),
                'rules' => $request->rules,
            ];

            if ($request->hasFile('cover_image')) {
                if ($group->cover_image) {
                    \Storage::disk('public')->delete($group->cover_image);
                }
                
                $data['cover_image'] = $request->file('cover_image')
                    ->store('community/groups', 'public');
            }

            $group->update($data);

            // ✅ Handle group_members admin entry
            if ($request->filled('admin_user_id')) {
                \DB::table('group_members')->updateOrInsert(
                    [
                        'group_id' => $group->id,
                        'role' => 'admin',
                    ],
                    [
                        'community_group_id' => $group->id, // adjust if different
                        'user_id' => $request->admin_user_id,
                        'status' => 'approved',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            return redirect()->route('admin.community.groups.index')
                ->with('success', 'Group updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating group: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete group
     */
    public function destroy(CommunityGroup $group)
    {
        try {
            if ($group->posts()->count() > 0) {
                return redirect()->route('admin.community.groups.index')
                    ->with('error', 'Cannot delete group with existing posts. Remove all posts first.');
            }

            if ($group->cover_image) {
                \Storage::disk('public')->delete($group->cover_image);
            }

            $group->members()->delete();
            $group->delete();

            return redirect()->route('admin.community.groups.index')
                ->with('success', 'Group deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.community.groups.index')
                ->with('error', 'Error deleting group: ' . $e->getMessage());
        }
    }

    /**
     * Toggle group status
     */
    public function toggleStatus(CommunityGroup $group): JsonResponse
    {
        try {
            $group->update(['is_active' => !$group->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Group status updated successfully',
                'is_active' => $group->is_active,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating group status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Manage group members
     */
    public function members(CommunityGroup $group)
    {
        $members = $group->activeMembers()
            ->with('user:id,name,email,avatar')
            ->orderByRaw("FIELD(role, 'admin', 'moderator', 'member')")
            ->orderBy('joined_at', 'desc')
            ->paginate(50);

        return view('admin.community.groups.members', compact('group', 'members'));
    }

    /**
     * Update member role
     */
    public function updateMemberRole(Request $request, CommunityGroup $group, User $user): JsonResponse
    {
        $request->validate([
            'role' => 'required|in:admin,moderator,member',
        ]);

        try {
            $membership = $group->members()->where('user_id', $user->id)->first();
            
            if (!$membership) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not a member of this group',
                ], 404);
            }

            if ($membership->role === 'admin' && $request->role !== 'admin') {
                $adminCount = $group->members()->where('role', 'admin')->count();
                if ($adminCount === 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot change role of the last admin',
                    ], 400);
                }
            }

            $membership->update(['role' => $request->role]);

            return response()->json([
                'success' => true,
                'message' => 'Member role updated successfully',
                'role' => $request->role,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating member role: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove member from group
     */
    public function removeMember(CommunityGroup $group, User $user): JsonResponse
    {
        try {
            $membership = $group->members()->where('user_id', $user->id)->first();
            
            if (!$membership) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not a member of this group',
                ], 404);
            }

            if ($membership->role === 'admin') {
                $adminCount = $group->members()->where('role', 'admin')->count();
                if ($adminCount === 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot remove the last admin',
                    ], 400);
                }
            }

            $membership->delete();
            $group->decrement('members_count');

            return response()->json([
                'success' => true,
                'message' => 'Member removed successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing member: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add member to group
     */
    public function addMember(Request $request, CommunityGroup $group): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,moderator,member',
        ]);

        try {
            $existingMembership = $group->members()->where('user_id', $request->user_id)->first();
            
            if ($existingMembership) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is already a member of this group',
                ], 400);
            }

            GroupMember::create([
                'community_group_id' => $group->id,
                'user_id' => $request->user_id,
                'role' => $request->role,
                'joined_at' => now(),
            ]);

            $group->increment('members_count');

            return response()->json([
                'success' => true,
                'message' => 'Member added successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding member: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'groups' => 'required|array',
            'groups.*' => 'exists:community_groups,id',
        ]);

        try {
            $groups = CommunityGroup::whereIn('id', $request->groups);

            switch ($request->action) {
                case 'activate':
                    $groups->update(['is_active' => true]);
                    $message = 'Groups activated successfully';
                    break;

                case 'deactivate':
                    $groups->update(['is_active' => false]);
                    $message = 'Groups deactivated successfully';
                    break;

                case 'delete':
                    // Check if any group has posts
                    $groupsWithPosts = $groups->withCount('posts')
                        ->get()
                        ->filter(function($group) {
                            return $group->posts_count > 0;
                        });

                    if ($groupsWithPosts->count() > 0) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot delete groups with existing posts',
                        ], 400);
                    }

                    // Delete all memberships and groups
                    foreach ($groups->get() as $group) {
                        $group->members()->delete();
                        if ($group->cover_image) {
                            \Storage::disk('public')->delete($group->cover_image);
                        }
                    }
                    
                    $groups->delete();
                    $message = 'Groups deleted successfully';
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error performing bulk action: ' . $e->getMessage(),
            ], 500);
        }
    }
} 