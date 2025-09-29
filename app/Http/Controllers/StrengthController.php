<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FitLiveSession;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;

class StrengthController extends Controller
{
    public function show($slug)
    {
        // Fetch subcategories
        $subcategories = SubCategory::where('category_id', 21)
            ->where('id', '!=', 17)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);


        $selectedSubcategory = $subcategories->firstWhere('slug', $slug);
        if (!$selectedSubcategory) {
            abort(404);
        }

        $now = Carbon::now();

        // Fetch all today sessions for the selected subcategory
        $sessions = FitLiveSession::liveToday()
            ->where('sub_category_id', $selectedSubcategory->id)
            ->orderBy('scheduled_at')
            ->get();

        // Find live session and upcoming sessions
        $liveSessionId = null;

        foreach ($sessions as $index => $session) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            $nextSession = $sessions->get($index + 1);
            $nextSessionTime = $nextSession ? Carbon::parse($nextSession->scheduled_at) : null;
            if ($now->gte($sessionTime)) {
                if ($nextSessionTime) {
                    // Show as live only if it's before the next session
                    if ($now->lt($nextSessionTime)) {
                        // But not more than 1 hour after start
                        if ($now->lte($sessionTime->copy()->addHour())) {
                            $liveSessionId = $session->id;
                            break;
                        }
                    }
                } else {
                    // No next session — show live only if within 1 hour
                    if ($now->lte($sessionTime->copy()->addHour())) {
                        $liveSessionId = $session->id;
                        break;
                    }
                }
            }
        }

        // Filter sessions to show only live session + upcoming sessions
        $filteredSessions = $sessions->filter(function ($session) use ($now, $liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            if ($session->id === $liveSessionId) {
                return true; // include live session
            }
            return $sessionTime->gte($now); // include upcoming sessions only
        })->values();

        // Prepare liveSlots
        $liveSlots = $filteredSessions->map(function ($session) use ($liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            return [
                'time' => $sessionTime->format('h:i A'),
                'is_live' => $session->id === $liveSessionId,
                'id' => $session->id,
                'title' => $session->title,
                'banner_image_url' => $session->banner_image_url,
            ];
        });

        // Active session is live session if found
        $activeSession = $sessions->firstWhere('id', $liveSessionId);

        // Instructor info
        $instructor = $activeSession ? User::find($activeSession->instructor_id) : null;


        // Archived sessions: today (excluding live/upcoming) + previous days
        $allPastSessions = FitLiveSession::where('sub_category_id', $selectedSubcategory->id)
            ->where('scheduled_at', '<', Carbon::now()) // Anything before now
            ->whereNotNull('ended_at')
            ->orderBy('ended_at', 'desc')
            ->get();

        // Filter out today’s sessions that are still live/upcoming
        $archivedSessions = $allPastSessions->filter(function ($session) use ($liveSlots) {
            // Skip if already shown as live/upcoming
            return !$liveSlots->contains('id', $session->id);
        });

        // Group by date (like 2025-09-26)
        $groupedArchived = $archivedSessions->groupBy(function ($session) {
            return Carbon::parse($session->scheduled_at)->format('Y-m-d');
        });

        return view('tools.active-session', [
            'subcategories' => $subcategories,
            'selectedSubcategory' => $selectedSubcategory,
            'activeSession' => $activeSession,
            'instructor' => $instructor,
            'liveSlots' => $liveSlots,
            'archivedSessions' => $archivedSessions,
            'groupedArchived' => $groupedArchived,
        ]);
    }
}
