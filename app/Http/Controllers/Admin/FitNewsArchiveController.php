<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitNews;
use Illuminate\Http\Request;

class FitNewsArchiveController extends Controller
{
    /**
     * Display a listing of archived FitNews recordings
     */
    public function index(Request $request)
    {
        $query = FitNews::withRecordings()
                        ->with('creator')
                        ->orderBy('ended_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by creator
        if ($request->filled('creator_id')) {
            $query->where('created_by', $request->creator_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('ended_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('ended_at', '<=', $request->date_to);
        }

        $recordings = $query->paginate(15);

        // Get creators for filter dropdown
        $creators = \App\Models\User::whereIn('id', 
            FitNews::withRecordings()->distinct()->pluck('created_by')
        )->get();

        return view('admin.fitnews.archive.index', compact('recordings', 'creators'));
    }

    /**
     * Display the specified archived recording
     */
    public function show(FitNews $fitNews)
    {
        // Ensure this is a recorded session
        if (!$fitNews->hasRecording()) {
            abort(404, 'Recording not found');
        }

        $fitNews->load('creator');

        return view('admin.fitnews.archive.show', compact('fitNews'));
    }

    /**
     * Download the recording file
     */
    public function download(FitNews $fitNews)
    {
        if (!$fitNews->hasRecording() || !file_exists($fitNews->recording_url)) {
            abort(404, 'Recording file not found');
        }

        return response()->download($fitNews->recording_url, 
            'fitnews_' . $fitNews->id . '_' . $fitNews->title . '.mp4');
    }

    /**
     * Delete an archived recording
     */
    public function destroy(FitNews $fitNews)
    {
        if (!$fitNews->hasRecording()) {
            return redirect()->back()->with('error', 'No recording found to delete');
        }

        // Delete the physical file if it exists
        if (file_exists($fitNews->recording_url)) {
            unlink($fitNews->recording_url);
        }

        // Clear recording data from database
        $fitNews->update([
            'recording_url' => null,
            'recording_id' => null,
            'recording_status' => null,
            'recording_duration' => null,
            'recording_file_size' => null,
        ]);

        return redirect()->route('admin.fitnews.archive.index')
                        ->with('success', 'Recording deleted successfully');
    }

    /**
     * Bulk delete multiple recordings
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'recordings' => 'required|array',
            'recordings.*' => 'exists:fit_news,id'
        ]);

        $deletedCount = 0;

        foreach ($request->recordings as $id) {
            $fitNews = FitNews::find($id);
            
            if ($fitNews && $fitNews->hasRecording()) {
                // Delete the physical file if it exists
                if (file_exists($fitNews->recording_url)) {
                    unlink($fitNews->recording_url);
                }

                // Clear recording data from database
                $fitNews->update([
                    'recording_url' => null,
                    'recording_id' => null,
                    'recording_status' => null,
                    'recording_duration' => null,
                    'recording_file_size' => null,
                ]);

                $deletedCount++;
            }
        }

        return redirect()->route('admin.fitnews.archive.index')
                        ->with('success', "Successfully deleted {$deletedCount} recordings");
    }
}
