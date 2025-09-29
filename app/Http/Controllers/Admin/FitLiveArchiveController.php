<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitLiveSession;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class FitLiveArchiveController extends Controller
{
    /**
     * Display a listing of archived FitLive recordings
     */
    public function index(Request $request)
    {
        $query = FitLiveSession::withRecordings()
                              ->with(['category', 'subCategory', 'instructor'])
                              ->orderBy('ended_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by instructor
        if ($request->filled('instructor_id')) {
            $query->where('instructor_id', $request->instructor_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('ended_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('ended_at', '<=', $request->date_to);
        }

        $recordings = $query->paginate(15);

        // Get categories and instructors for filter dropdowns
        $categories = Category::whereIn('id', 
            FitLiveSession::withRecordings()->distinct()->pluck('category_id')
        )->get();

        $instructors = User::whereIn('id', 
            FitLiveSession::withRecordings()->distinct()->pluck('instructor_id')
        )->get();

        return view('admin.fitlive.archive.index', compact('recordings', 'categories', 'instructors'));
    }

    /**
     * Display the specified archived recording
     */
    public function show(FitLiveSession $fitLiveSession)
    {
        // Ensure this is a recorded session
        if (!$fitLiveSession->hasRecording()) {
            abort(404, 'Recording not found');
        }

        $fitLiveSession->load(['category', 'subCategory', 'instructor', 'chatMessages' => function ($query) {
            $query->with('user')->orderBy('created_at', 'asc');
        }]);

        return view('admin.fitlive.archive.show', compact('fitLiveSession'));
    }

    /**
     * Download the recording file
     */
    public function download(FitLiveSession $fitLiveSession)
    {
        if (!$fitLiveSession->hasRecording() || !file_exists($fitLiveSession->recording_url)) {
            abort(404, 'Recording file not found');
        }

        return response()->download($fitLiveSession->recording_url, 
            'fitlive_' . $fitLiveSession->id . '_' . $fitLiveSession->title . '.mp4');
    }

    /**
     * Delete an archived recording
     */
    public function destroy(FitLiveSession $fitLiveSession)
    {
        if (!$fitLiveSession->hasRecording()) {
            return redirect()->back()->with('error', 'No recording found to delete');
        }

        // Delete the physical file if it exists
        if (file_exists($fitLiveSession->recording_url)) {
            unlink($fitLiveSession->recording_url);
        }

        // Clear recording data from database
        $fitLiveSession->update([
            'recording_url' => null,
            'recording_id' => null,
            'recording_status' => null,
            'recording_duration' => null,
            'recording_file_size' => null,
        ]);

        return redirect()->route('admin.fitlive.archive.index')
                        ->with('success', 'Recording deleted successfully');
    }

    /**
     * Bulk delete multiple recordings
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'recordings' => 'required|array',
            'recordings.*' => 'exists:fitlive_sessions,id'
        ]);

        $deletedCount = 0;

        foreach ($request->recordings as $id) {
            $session = FitLiveSession::find($id);
            
            if ($session && $session->hasRecording()) {
                // Delete the physical file if it exists
                if (file_exists($session->recording_url)) {
                    unlink($session->recording_url);
                }

                // Clear recording data from database
                $session->update([
                    'recording_url' => null,
                    'recording_id' => null,
                    'recording_status' => null,
                    'recording_duration' => null,
                    'recording_file_size' => null,
                ]);

                $deletedCount++;
            }
        }

        return redirect()->route('admin.fitlive.archive.index')
                        ->with('success', "Successfully deleted {$deletedCount} recordings");
    }
}
