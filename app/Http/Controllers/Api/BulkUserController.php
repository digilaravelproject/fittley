<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BulkUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:admin']);
    }

    /**
     * Bulk create users
     */
    public function bulkCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'users' => 'required|array|min:1|max:100',
            'users.*.name' => 'required|string|max:255',
            'users.*.email' => 'required|string|email|max:255|unique:users',
            'users.*.password' => 'required|string|min:8',
            'users.*.role' => 'nullable|string|exists:roles,name'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $createdUsers = [];
            $errors = [];

            foreach ($request->users as $index => $userData) {
                try {
                    $user = User::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => Hash::make($userData['password']),
                        'email_verified_at' => now()
                    ]);

                    if (isset($userData['role'])) {
                        $user->assignRole($userData['role']);
                    }

                    $createdUsers[] = $user;
                } catch (\Exception $e) {
                    $errors[] = [
                        'index' => $index,
                        'email' => $userData['email'],
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bulk user creation completed',
                'data' => [
                    'created_count' => count($createdUsers),
                    'error_count' => count($errors),
                    'created_users' => $createdUsers,
                    'errors' => $errors
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Bulk creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update users
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'updates' => 'required|array|min:1|max:100',
            'updates.*.id' => 'required|integer|exists:users,id',
            'updates.*.name' => 'nullable|string|max:255',
            'updates.*.email' => 'nullable|string|email|max:255',
            'updates.*.phone' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $updatedUsers = [];
            $errors = [];

            foreach ($request->updates as $index => $updateData) {
                try {
                    $user = User::findOrFail($updateData['id']);
                    
                    $fieldsToUpdate = collect($updateData)->except('id')->filter()->toArray();
                    
                    if (!empty($fieldsToUpdate)) {
                        $user->update($fieldsToUpdate);
                        $updatedUsers[] = $user->fresh();
                    }
                } catch (\Exception $e) {
                    $errors[] = [
                        'index' => $index,
                        'id' => $updateData['id'],
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bulk user update completed',
                'data' => [
                    'updated_count' => count($updatedUsers),
                    'error_count' => count($errors),
                    'updated_users' => $updatedUsers,
                    'errors' => $errors
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Bulk update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete users (soft delete)
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array|min:1|max:100',
            'user_ids.*' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $currentUserId = auth()->id();
            $userIds = array_diff($request->user_ids, [$currentUserId]); // Prevent self-deletion

            $deletedCount = User::whereIn('id', $userIds)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bulk user deletion completed',
                'data' => [
                    'deleted_count' => $deletedCount,
                    'skipped_current_user' => in_array($currentUserId, $request->user_ids)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk status change (activate/deactivate users)
     */
    public function bulkStatusChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array|min:1|max:100',
            'user_ids.*' => 'required|integer|exists:users,id',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $statusField = $request->status === 'active' ? ['email_verified_at' => now()] : ['email_verified_at' => null];
            
            $updatedCount = User::whereIn('id', $request->user_ids)
                ->update($statusField);

            return response()->json([
                'success' => true,
                'message' => "Bulk status change to {$request->status} completed",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_status' => $request->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk status change failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
