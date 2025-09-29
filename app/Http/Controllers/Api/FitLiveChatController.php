<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitLiveSession;
use App\Models\FitLiveChatMessage;
use App\Events\FitLiveChatMessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FitLiveChatController extends Controller
{
    /**
     * Get chat messages for a session
     */
    public function getMessages($id, Request $request)
    {
        $session = FitLiveSession::findOrFail($id);
        
        // Allow instructors to always access chat messages for their sessions
        if (Auth::check() && Auth::user()->hasRole('instructor') && $session->instructor_id === Auth::id()) {
            $messages = FitLiveChatMessage::with('user:id,name')
                ->where('fitlive_session_id', $session->id)
                ->orderBy('sent_at', 'desc')
                ->limit(50)
                ->get()
                ->reverse()
                ->values();

            return response()->json([
                'success' => true,
                'messages' => $messages,
                'chat_enabled' => true,
                'instructor_access' => true
            ]);
        }
        
        // Check if chat is enabled for this session for regular users
        if ($session->chat_mode === 'off') {
            return response()->json([
                'success' => false,
                'message' => 'Chat is disabled for this session'
            ], 403);
        }

        // Check chat availability based on session status
        if ($session->chat_mode === 'during' && !$session->isLive()) {
            return response()->json([
                'success' => false,
                'message' => 'Chat is only available during live sessions'
            ], 403);
        }

        $messages = FitLiveChatMessage::with('user:id,name')
            ->where('fitlive_session_id', $session->id)
            ->orderBy('sent_at', 'desc')
            ->limit(50)
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'chat_enabled' => $this->isChatEnabled($session)
        ]);
    }

    /**
     * Send a chat message
     */
    public function sendMessage($id, Request $request)
    {
        $session = FitLiveSession::findOrFail($id);
        
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to send messages'
            ], 401);
        }

        $user = Auth::user();
        $isInstructor = $user->hasRole('instructor') && $session->instructor_id === $user->id;

        // Allow instructors to send messages even if chat is disabled
        if (!$isInstructor) {
            // Check if chat is enabled for this session
            if ($session->chat_mode === 'off') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat is disabled for this session'
                ], 403);
            }

            // Check chat availability based on session status
            if ($session->chat_mode === 'during' && !$session->isLive()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat is only available during live sessions'
                ], 403);
            }
        }

        $request->validate([
            'body' => 'required|string|max:500',
            'is_instructor' => 'sometimes|boolean'
        ]);

        $chatMessage = FitLiveChatMessage::create([
            'fitlive_session_id' => $session->id,
            'user_id' => $user->id,
            'body' => $request->input('body'),
            'is_instructor' => $isInstructor,
            'sent_at' => now()
        ]);

        $chatMessage->load('user:id,name');

        // Add instructor flag to the message data
        $messageData = $chatMessage->toArray();
        $messageData['is_instructor'] = $isInstructor;

        // Broadcast the message to all viewers
        broadcast(new FitLiveChatMessageSent($chatMessage))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $messageData
        ]);
    }

    /**
     * Check if chat is enabled for the session
     */
    private function isChatEnabled(FitLiveSession $session)
    {
        if ($session->chat_mode === 'off') {
            return false;
        }

        if ($session->chat_mode === 'during') {
            return $session->isLive();
        }

        if ($session->chat_mode === 'after') {
            return $session->isLive() || $session->hasEnded();
        }

        return false;
    }

    /**
     * Get chat status for a session
     */
    public function getChatStatus($id)
    {
        $session = FitLiveSession::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'chat_enabled' => $this->isChatEnabled($session),
            'chat_mode' => $session->chat_mode,
            'session_status' => $session->status,
            'message_count' => $session->chatMessages()->count()
        ]);
    }
}
