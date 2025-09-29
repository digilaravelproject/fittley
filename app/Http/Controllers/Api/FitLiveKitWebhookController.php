<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitLiveSession;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FitLiveKitWebhookController extends Controller
{
    /**
     * Handle LiveKit webhook events
     */
    public function __invoke(Request $request): JsonResponse
    {
        $event = $request->input('event');
        $data = $request->input('data', []);

        Log::info('LiveKit webhook received', [
            'event' => $event,
            'data' => $data,
        ]);

        try {
            switch ($event) {
                case 'egress_started':
                    $this->handleEgressStarted($data);
                    break;

                case 'egress_ended':
                    $this->handleEgressEnded($data);
                    break;

                case 'room_started':
                    $this->handleRoomStarted($data);
                    break;

                case 'room_finished':
                    $this->handleRoomFinished($data);
                    break;

                case 'participant_joined':
                    $this->handleParticipantJoined($data);
                    break;

                case 'participant_left':
                    $this->handleParticipantLeft($data);
                    break;

                default:
                    Log::info('Unhandled LiveKit webhook event', ['event' => $event]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error processing LiveKit webhook', [
                'event' => $event,
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Handle egress started event
     */
    private function handleEgressStarted(array $data): void
    {
        $roomName = $data['room_name'] ?? null;
        $egressId = $data['egress_id'] ?? null;

        if ($roomName && $egressId) {
            $session = FitLiveSession::where('livekit_room', $roomName)->first();
            if ($session) {
                $session->update(['egress_id' => $egressId]);
                Log::info('Egress started for session', ['session_id' => $session->id, 'egress_id' => $egressId]);
            }
        }
    }

    /**
     * Handle egress ended event
     */
    private function handleEgressEnded(array $data): void
    {
        $egressId = $data['egress_id'] ?? null;
        $filePath = $data['file_path'] ?? null;

        if ($egressId) {
            $session = FitLiveSession::where('egress_id', $egressId)->first();
            if ($session && $filePath) {
                $session->update(['mp4_path' => $filePath]);
                Log::info('Egress ended for session', ['session_id' => $session->id, 'file_path' => $filePath]);
            }
        }
    }

    /**
     * Handle room started event
     */
    private function handleRoomStarted(array $data): void
    {
        $roomName = $data['room_name'] ?? null;

        if ($roomName) {
            $session = FitLiveSession::where('livekit_room', $roomName)->first();
            if ($session && $session->isScheduled()) {
                $session->update(['status' => 'live']);
                Log::info('Room started, session status updated', ['session_id' => $session->id]);
            }
        }
    }

    /**
     * Handle room finished event
     */
    private function handleRoomFinished(array $data): void
    {
        $roomName = $data['room_name'] ?? null;

        if ($roomName) {
            $session = FitLiveSession::where('livekit_room', $roomName)->first();
            if ($session && $session->isLive()) {
                $session->update(['status' => 'ended']);
                Log::info('Room finished, session status updated', ['session_id' => $session->id]);
            }
        }
    }

    /**
     * Handle participant joined event
     */
    private function handleParticipantJoined(array $data): void
    {
        $roomName = $data['room_name'] ?? null;
        $participantCount = $data['participant_count'] ?? 0;

        if ($roomName) {
            $session = FitLiveSession::where('livekit_room', $roomName)->first();
            if ($session) {
                // Update viewer peak if current count is higher
                if ($participantCount > $session->viewer_peak) {
                    $session->update(['viewer_peak' => $participantCount]);
                }
            }
        }
    }

    /**
     * Handle participant left event
     */
    private function handleParticipantLeft(array $data): void
    {
        // Currently no specific action needed when participant leaves
        // Could be used for analytics or cleanup
        Log::info('Participant left', $data);
    }
}
