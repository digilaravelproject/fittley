<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageHero;
use App\Http\Requests\StoreHomepageHeroRequest;
use Illuminate\Http\Request;

class HomepageHeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HomepageHero::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $heroes = $query->paginate(10)->withQueryString();

        return view('admin.homepage.hero.index', compact('heroes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.homepage.hero.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomepageHeroRequest $request)
    {
        $data = $request->validated();
        
        // Extract YouTube video ID from URL if provided
        if (!empty($data['youtube_video_url'])) {
            $data['youtube_video_id'] = HomepageHero::extractYoutubeId($data['youtube_video_url']);
        } else {
            $data['youtube_video_id'] = null;
        }
        
        // Remove the URL from data as we only store the ID
        unset($data['youtube_video_url']);

        HomepageHero::create($data);

        return redirect()->route('admin.homepage.hero.index')
                        ->with('success', 'Homepage hero created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomepageHero $homepageHero)
    {
        return view('admin.homepage.hero.show', compact('homepageHero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomepageHero $homepageHero)
    {
        return view('admin.homepage.hero.edit', compact('homepageHero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreHomepageHeroRequest $request, HomepageHero $homepageHero)
    {
        $data = $request->validated();
        
        // Extract YouTube video ID from URL if provided
        if (!empty($data['youtube_video_url'])) {
            $data['youtube_video_id'] = HomepageHero::extractYoutubeId($data['youtube_video_url']);
        } else {
            $data['youtube_video_id'] = null;
        }
        
        // Remove the URL from data as we only store the ID
        unset($data['youtube_video_url']);
        
        $homepageHero->update($data);

        return redirect()->route('admin.homepage.hero.index')
                        ->with('success', 'Homepage hero updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomepageHero $homepageHero)
    {
        $homepageHero->delete();

        return redirect()->route('admin.homepage.hero.index')
                        ->with('success', 'Homepage hero deleted successfully.');
    }

    /**
     * Toggle the status of the resource.
     */
    public function toggleStatus(HomepageHero $homepageHero)
    {
        $homepageHero->update(['is_active' => !$homepageHero->is_active]);

        $status = $homepageHero->is_active ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'message' => "Homepage hero {$status} successfully.",
            'is_active' => $homepageHero->is_active
        ]);
    }
}
