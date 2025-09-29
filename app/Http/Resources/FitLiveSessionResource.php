<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FitLiveSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'visibility' => $this->visibility,
            
            // Scheduling
            'scheduled_at' => $this->scheduled_at?->toISOString(),
            'started_at' => $this->started_at?->toISOString(),
            'ended_at' => $this->ended_at?->toISOString(),
            
            // Streaming
            'livekit_room' => $this->livekit_room,
            'hls_url' => $this->hls_url,
            'chat_mode' => $this->chat_mode,
            'viewer_peak' => $this->viewer_peak,
            
            // Media
            'banner_image' => $this->getBannerImageUrl(),
            
            // Recording
            'recording' => [
                'enabled' => $this->recording_enabled,
                'url' => $this->recording_url,
                'status' => $this->recording_status,
                'duration' => $this->recording_duration,
                'file_size' => $this->recording_file_size,
            ],
            
            // Relationships
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                ];
            }),
            'sub_category' => $this->whenLoaded('subCategory', function () {
                return [
                    'id' => $this->subCategory->id,
                    'name' => $this->subCategory->name,
                ];
            }),
            'instructor' => $this->whenLoaded('instructor', function () {
                return [
                    'id' => $this->instructor->id,
                    'name' => $this->instructor->name,
                    'avatar' => $this->instructor->avatar ?? null,
                ];
            }),
            
            // Status helpers
            'is_live' => $this->status === 'live',
            'is_upcoming' => $this->status === 'scheduled' && $this->scheduled_at > now(),
            'is_archived' => $this->status === 'ended',
            'can_join' => $this->status === 'live' || ($this->status === 'scheduled' && $this->scheduled_at <= now()),
            
            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    /**
     * Get banner image URL
     */
    private function getBannerImageUrl(): ?string
    {
        if (!$this->banner_image) {
            return null;
        }

        if (filter_var($this->banner_image, FILTER_VALIDATE_URL)) {
            return $this->banner_image;
        }

        return Storage::url($this->banner_image);
    }
}
