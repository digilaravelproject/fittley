<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CommunityPost::with(['user:id,name,avatar', 'category:id,name,color']);

        // Filter by category
        if ($request->category_id) {
            $query->where('community_category_id', $request->category_id);
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('content', 'like', "%{$request->search}%")
                    ->orWhereHas('user', function ($subQ) use ($request) {
                        $subQ->where('name', 'like', "%{$request->search}%");
                    });
            });
        }

        $posts = $query->latest()->paginate(15);
        $categories = CommunityCategory::where('is_active', true)->get(['id', 'name']);

        return view('admin.community.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CommunityCategory::where('is_active', true)->get(['id', 'name']);
        return view('admin.community.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'community_category_id' => 'required|exists:community_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title', 'content', 'community_category_id', 'tags']);
        $data['user_id'] = Auth::id();
        $data['is_published'] = $request->status === 'published';
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = true;

        // Upload featured image
        if ($request->hasFile('featured_image')) {
            $data['images'] = $request->file('featured_image')->store('community/posts', 'public');
        }

        CommunityPost::create($data);

        return redirect()->route('admin.community.posts.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityPost $post)
    {
        $post->load(['user:id,name,avatar', 'category:id,name,color']);
        return view('admin.community.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityPost $post)
    {
        $categories = CommunityCategory::where('is_active', true)->get(['id', 'name']);
        return view('admin.community.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityPost $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'community_category_id' => 'required|exists:community_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title', 'content', 'community_category_id', 'tags']);
        $data['is_published'] = $request->status === 'published';
        $data['is_featured'] = $request->has('is_featured');

        // Replace image if new uploaded
        if ($request->hasFile('featured_image')) {
            if ($post->images) {
                Storage::disk('public')->delete($post->images);
            }
            $data['images'] = $request->file('featured_image')->store('community/posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.community.posts.show', $post->id)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityPost $post)
    {
        if ($post->images) {
            Storage::disk('public')->delete($post->images);
        }
        $post->delete();

        return redirect()->route('admin.community.posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Toggle post status.
     */
    public function toggleStatus(CommunityPost $post)
    {
        $post->is_published = !$post->is_published;
        $post->save();

        return back()->with('success', 'Post status updated successfully!');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(CommunityPost $post)
    {
        $post->is_featured = !$post->is_featured;
        $post->save();

        return back()->with('success', 'Post featured status updated successfully!');
    }

    /**
     * Handle bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,unpublish,feature,unfeature',
            'posts' => 'required|array',
            'posts.*' => 'integer',
        ]);

        $posts = CommunityPost::whereIn('id', $request->posts)->get();

        foreach ($posts as $post) {
            switch ($request->action) {
                case 'delete':
                    if ($post->images) {
                        Storage::disk('public')->delete($post->images);
                    }
                    $post->delete();
                    break;
                case 'publish':
                    $post->is_published = true;
                    $post->save();
                    break;
                case 'unpublish':
                    $post->is_published = false;
                    $post->save();
                    break;
                case 'feature':
                    $post->is_featured = true;
                    $post->save();
                    break;
                case 'unfeature':
                    $post->is_featured = false;
                    $post->save();
                    break;
            }
        }

        return back()->with('success', 'Bulk action completed successfully!');
    }
}
