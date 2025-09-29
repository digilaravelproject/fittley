<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FittalkSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class FittalkAdminController extends Controller
{
    /**
     * Display listing of FitTalk sessions
     */
    public function index(Request $request)
    {
        $query = FittalkSession::with(['user:id,name,email', 'instructor:id,name,email']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->instructor_id) {
            $query->where('instructor_id', $request->instructor_id);
        }

        $sessions = $query->orderBy('scheduled_at', 'desc')->paginate(25);

        $instructors = User::whereHas('roles', function($q) {
            $q->where('name', 'instructor');
        })->select('id', 'name')->get();

        return view('admin.community.fittalk.index', compact('sessions', 'instructors'));
    }

    /**
     * Display session details
     */
    public function show(FittalkSession $session)
    {
        $session->load([
            'user:id,name,email,avatar,phone',
            'instructor:id,name,email,avatar,phone'
        ]);

        return view('admin.community.fittalk.show', compact('session'));
    }

    /**
     * Update session status
     */
    public function updateStatus(Request $request, FittalkSession $session): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:scheduled,in_progress,completed,cancelled,no_show',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $session->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
            ]);

            if ($request->status === 'completed' && !$session->ended_at) {
                $session->update(['ended_at' => now()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Session status updated successfully',
                'status' => $request->status,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating session status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * FitTalk analytics dashboard
     */
    public function analytics()
    {
        $stats = $this->getFittalkStats();
        
        return view('admin.community.fittalk.analytics', compact('stats'));
    }

    /**
     * Get FitTalk analytics data
     */
    public function analyticsData(Request $request): JsonResponse
    {
        $request->validate([
            'period' => 'nullable|in:7,30,90,365',
            'instructor_id' => 'nullable|exists:users,id',
        ]);

        $period = $request->period ?? 30;
        $instructorId = $request->instructor_id;

        $data = $this->getAnalyticsData($period, $instructorId);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Instructor performance report
     */
    public function instructorReport(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'period' => 'nullable|in:week,month,quarter,year',
        ]);

        $instructor = User::findOrFail($request->instructor_id);
        $period = $request->period ?? 'month';

        $stats = $this->getInstructorStats($instructor, $period);

        return view('admin.community.fittalk.instructor-report', compact('instructor', 'stats', 'period'));
    }

    /**
     * Revenue analytics
     */
    public function revenue(Request $request)
    {
        $request->validate([
            'period' => 'nullable|in:week,month,quarter,year',
        ]);

        $period = $request->period ?? 'month';
        $revenueData = $this->getRevenueData($period);

        return view('admin.community.fittalk.revenue', compact('revenueData', 'period'));
    }

    /**
     * Cancel session
     */
    public function cancelSession(Request $request, FittalkSession $session): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $session->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $request->reason,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session cancelled successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling session: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get FitTalk statistics
     */
    private function getFittalkStats(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'sessions' => [
                'total' => FittalkSession::count(),
                'today' => FittalkSession::whereDate('scheduled_at', $today)->count(),
                'this_week' => FittalkSession::where('scheduled_at', '>=', $thisWeek)->count(),
                'this_month' => FittalkSession::where('scheduled_at', '>=', $thisMonth)->count(),
                'completed' => FittalkSession::where('status', 'completed')->count(),
                'cancelled' => FittalkSession::where('status', 'cancelled')->count(),
                'no_shows' => FittalkSession::where('status', 'no_show')->count(),
            ],

            'revenue' => [
                'total' => FittalkSession::where('status', 'completed')->sum('cost'),
                'this_month' => FittalkSession::where('status', 'completed')
                    ->where('created_at', '>=', $thisMonth)
                    ->sum('cost'),
                'this_week' => FittalkSession::where('status', 'completed')
                    ->where('created_at', '>=', $thisWeek)
                    ->sum('cost'),
                'average_session_cost' => FittalkSession::where('status', 'completed')->avg('cost'),
            ],

            'instructors' => [
                'total_active' => User::whereHas('roles', function($q) {
                    $q->where('name', 'instructor');
                })->whereHas('instructorSessions', function($q) use ($thisMonth) {
                    $q->where('created_at', '>=', $thisMonth);
                })->count(),
                
                'top_performers' => User::whereHas('roles', function($q) {
                    $q->where('name', 'instructor');
                })->withCount(['instructorSessions as completed_sessions' => function($q) {
                    $q->where('status', 'completed');
                }])->orderBy('completed_sessions', 'desc')
                ->take(5)
                ->get(['id', 'name', 'avatar', 'completed_sessions']),
            ],

            'bookings' => [
                'peak_hours' => FittalkSession::selectRaw('HOUR(scheduled_at) as hour, COUNT(*) as count')
                    ->groupBy('hour')
                    ->orderBy('count', 'desc')
                    ->take(3)
                    ->get(),
                
                'popular_days' => FittalkSession::selectRaw('DAYNAME(scheduled_at) as day, COUNT(*) as count')
                    ->groupBy('day')
                    ->orderBy('count', 'desc')
                    ->get(),
            ],
        ];
    }

    /**
     * Get analytics data for charts
     */
    private function getAnalyticsData(int $days, ?int $instructorId = null): array
    {
        $startDate = Carbon::now()->subDays($days);
        $query = FittalkSession::where('created_at', '>=', $startDate);

        if ($instructorId) {
            $query->where('instructor_id', $instructorId);
        }

        // Sessions by day
        $sessionsByDay = $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by day
        $revenueByDay = $query->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(cost) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Status distribution
        $statusDistribution = $query->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return [
            'sessions_by_day' => $sessionsByDay,
            'revenue_by_day' => $revenueByDay,
            'status_distribution' => $statusDistribution,
        ];
    }

    /**
     * Get instructor performance statistics
     */
    private function getInstructorStats(User $instructor, string $period): array
    {
        $startDate = match($period) {
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'quarter' => Carbon::now()->startOfQuarter(),
            'year' => Carbon::now()->startOfYear(),
        };

        $sessions = $instructor->instructorSessions()
            ->where('created_at', '>=', $startDate);

        return [
            'total_sessions' => $sessions->count(),
            'completed_sessions' => $sessions->where('status', 'completed')->count(),
            'cancelled_sessions' => $sessions->where('status', 'cancelled')->count(),
            'no_show_sessions' => $sessions->where('status', 'no_show')->count(),
            'total_revenue' => $sessions->where('status', 'completed')->sum('cost'),
            'average_rating' => $sessions->where('status', 'completed')->avg('rating'),
            'completion_rate' => $sessions->count() > 0 
                ? ($sessions->where('status', 'completed')->count() / $sessions->count()) * 100 
                : 0,
        ];
    }

    /**
     * Get revenue data
     */
    private function getRevenueData(string $period): array
    {
        $startDate = match($period) {
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'quarter' => Carbon::now()->startOfQuarter(),
            'year' => Carbon::now()->startOfYear(),
        };

        $sessions = FittalkSession::where('status', 'completed')
            ->where('created_at', '>=', $startDate);

        return [
            'total_revenue' => $sessions->sum('cost'),
            'total_sessions' => $sessions->count(),
            'average_session_value' => $sessions->avg('cost'),
            'top_instructors_by_revenue' => User::whereHas('roles', function($q) {
                $q->where('name', 'instructor');
            })->withSum(['instructorSessions as total_revenue' => function($q) use ($startDate) {
                $q->where('status', 'completed')
                  ->where('created_at', '>=', $startDate);
            }], 'cost')->orderBy('total_revenue', 'desc')
            ->take(10)
            ->get(['id', 'name', 'total_revenue']),
        ];
    }
} 