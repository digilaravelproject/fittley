<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\PostComment;
use App\Models\User;
use App\Models\DirectMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommunityModerationController extends Controller
{
    /**
     * Moderation dashboard
     */
    public function index()
    {
        $stats = [
            'flagged_posts' => CommunityPost::where('is_flagged', true)->count(),
            // 'flagged_comments' => PostComment::where('is_flagged', true)->count(),
            // 'blocked_users' => User::where('is_blocked', true)->count(),
        ];

        $flaggedPosts = CommunityPost::where('is_flagged', true)
            ->with(['user:id,name,email', 'category:id,name'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.community.moderation.index', compact('stats', 'flaggedPosts'));
    }

    /**
     * Flagged posts management
     */
    public function flaggedPosts(Request $request)
    {
        $query = CommunityPost::where('is_flagged', true)
            ->with(['user:id,name,email,avatar', 'category:id,name']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('content', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function($subQ) use ($request) {
                      $subQ->where('name', 'like', "%{$request->search}%");
                  });
            });
        }

        $posts = $query->orderBy('flagged_at', 'desc')->paginate(20);

        return view('admin.community.moderation.flagged-posts', compact('posts'));
    }

    /**
     * Flagged comments management
     */
    public function flaggedComments(Request $request)
    {
        $query = PostComment::where('is_flagged', true)
            ->with(['user:id,name,email,avatar', 'post:id,content']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('content', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function($subQ) use ($request) {
                      $subQ->where('name', 'like', "%{$request->search}%");
                  });
            });
        }

        $comments = $query->orderBy('flagged_at', 'desc')->paginate(20);

        echo'<pre>';print_r($comments);die;

        return view('admin.community.moderation.flagged-comments', compact('comments'));
    }

    /**
     * Blocked users management
     */
    public function blockedUsers(Request $request)
    {
        $query = User::where('is_blocked', true);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->orderBy('blocked_at', 'desc')->paginate(20);

        return view('admin.community.moderation.blocked-users', compact('users'));
    }

    /**
     * Flag content
     */
    public function flagContent(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer',
            'reason' => 'required|string|max:500',
        ]);

        try {
            if ($request->type === 'post') {
                $post = CommunityPost::findOrFail($request->id);
                $post->update([
                    'is_flagged' => true,
                    'flagged_at' => now(),
                    'flag_reason' => $request->reason,
                ]);
                $message = 'Post flagged successfully';
            } else {
                $comment = PostComment::findOrFail($request->id);
                $comment->update([
                    'is_flagged' => true,
                    'flagged_at' => now(),
                    'flag_reason' => $request->reason,
                ]);
                $message = 'Comment flagged successfully';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error flagging content: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Unflag content
     */
    public function unflagContent(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer',
        ]);

        try {
            if ($request->type === 'post') {
                $post = CommunityPost::findOrFail($request->id);
                $post->update([
                    'is_flagged' => false,
                    'flagged_at' => null,
                    'flag_reason' => null,
                ]);
                $message = 'Post unflagged successfully';
            } else {
                $comment = PostComment::findOrFail($request->id);
                $comment->update([
                    'is_flagged' => false,
                    'flagged_at' => null,
                    'flag_reason' => null,
                ]);
                $message = 'Comment unflagged successfully';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error unflagging content: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete flagged content
     */
    public function deleteContent(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:post,comment',
            'id' => 'required|integer',
            'reason' => 'required|string|max:500',
        ]);

        try {
            if ($request->type === 'post') {
                $post = CommunityPost::findOrFail($request->id);
                
                // Delete associated comments first
                $post->comments()->delete();
                
                // Delete associated likes
                $post->likes()->delete();
                
                // Delete post images if any
                if ($post->images) {
                    foreach ($post->images as $image) {
                        \Storage::disk('public')->delete($image);
                    }
                }
                
                $post->delete();
                $message = 'Post deleted successfully';
            } else {
                $comment = PostComment::findOrFail($request->id);
                
                // Delete nested replies
                $comment->replies()->delete();
                
                $comment->delete();
                $message = 'Comment deleted successfully';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting content: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Block user
     */
    public function blockUser(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $user->update([
                'is_blocked' => true,
                'blocked_at' => now(),
                'block_reason' => $request->reason,
                'blocked_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User blocked successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error blocking user: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Unblock user
     */
    public function unblockUser(User $user): JsonResponse
    {
        try {
            $user->update([
                'is_blocked' => false,
                'blocked_at' => null,
                'block_reason' => null,
                'blocked_by' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User unblocked successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error unblocking user: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk moderation actions
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:flag,unflag,delete,block_users',
            'type' => 'required|in:posts,comments,users',
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $count = 0;

            foreach ($request->ids as $id) {
                if ($request->type === 'posts') {
                    $post = CommunityPost::find($id);
                    if ($post) {
                        match($request->action) {
                            'flag' => $post->update([
                                'is_flagged' => true,
                                'flagged_at' => now(),
                                'flag_reason' => $request->reason,
                            ]),
                            'unflag' => $post->update([
                                'is_flagged' => false,
                                'flagged_at' => null,
                                'flag_reason' => null,
                            ]),
                            'delete' => $post->delete(),
                        };
                        $count++;
                    }
                } elseif ($request->type === 'comments') {
                    $comment = PostComment::find($id);
                    if ($comment) {
                        match($request->action) {
                            'flag' => $comment->update([
                                'is_flagged' => true,
                                'flagged_at' => now(),
                                'flag_reason' => $request->reason,
                            ]),
                            'unflag' => $comment->update([
                                'is_flagged' => false,
                                'flagged_at' => null,
                                'flag_reason' => null,
                            ]),
                            'delete' => $comment->delete(),
                        };
                        $count++;
                    }
                } elseif ($request->type === 'users' && $request->action === 'block_users') {
                    $user = User::find($id);
                    if ($user) {
                        $user->update([
                            'is_blocked' => true,
                            'blocked_at' => now(),
                            'block_reason' => $request->reason,
                        ]);
                        $count++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Bulk action completed successfully. {$count} items processed.",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error performing bulk action: ' . $e->getMessage(),
            ], 500);
        }
    }
} 