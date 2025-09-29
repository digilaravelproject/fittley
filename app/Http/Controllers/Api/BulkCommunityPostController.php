<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BulkCommunityPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Bulk create community posts
     */
    public function bulkCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'posts' => 'required|array|min:1|max:20',
            'posts.*.content' => 'required|string|max:2000',
            'posts.*.category_id' => 'nullable|integer|exists:community_categories,id',
            'posts.*.group_id' => 'nullable|integer|exists:community_groups,id',
            'posts.*.visibility' => 'nullable|in:public,friends,private',
            'posts.*.media_paths' => 'nullable|array'
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

            $createdPosts = [];
            $errors = [];

            foreach ($request->posts as $index => $postData) {
                try {
                    $post = CommunityPost::create(array_merge($postData, [
                        'user_id' => auth()->id(),
                        'visibility' => $postData['visibility'] ?? 'public'
                    ]));

                    $createdPosts[] = $post;
                } catch (\Exception $e) {
                    $errors[] = [
                        'index' => $index,
                        'content_preview' => substr($postData['content'], 0, 50) . '...',
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bulk post creation completed',
                'data' => [
                    'created_count' => count($createdPosts),
                    'error_count' => count($errors),
                    'created_posts' => $createdPosts,
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
     * Bulk update community posts
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'updates' => 'required|array|min:1|max:20',
            'updates.*.id' => 'required|integer|exists:community_posts,id',
            'updates.*.content' => 'nullable|string|max:2000',
            'updates.*.visibility' => 'nullable|in:public,friends,private'
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

            $updatedPosts = [];
            $errors = [];

            foreach ($request->updates as $index => $updateData) {
                try {
                    $post = CommunityPost::where('id', $updateData['id'])
                        ->where('user_id', auth()->id())
                        ->firstOrFail();
                    
                    $fieldsToUpdate = collect($updateData)->except('id')->filter()->toArray();
                    
                    if (!empty($fieldsToUpdate)) {
                        $post->update($fieldsToUpdate);
                        $updatedPosts[] = $post->fresh();
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
                'message' => 'Bulk post update completed',
                'data' => [
                    'updated_count' => count($updatedPosts),
                    'error_count' => count($errors),
                    'updated_posts' => $updatedPosts,
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
     * Bulk delete community posts
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_ids' => 'required|array|min:1|max:20',
            'post_ids.*' => 'required|integer|exists:community_posts,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $deletedCount = CommunityPost::whereIn('id', $request->post_ids)
                ->where('user_id', auth()->id())
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bulk post deletion completed',
                'data' => [
                    'deleted_count' => $deletedCount
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
     * Bulk status/visibility change
     */
    public function bulkStatusChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_ids' => 'required|array|min:1|max:20',
            'post_ids.*' => 'required|integer|exists:community_posts,id',
            'visibility' => 'required|in:public,friends,private'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updatedCount = CommunityPost::whereIn('id', $request->post_ids)
                ->where('user_id', auth()->id())
                ->update(['visibility' => $request->visibility]);

            return response()->json([
                'success' => true,
                'message' => "Bulk visibility change to {$request->visibility} completed",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_visibility' => $request->visibility
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
