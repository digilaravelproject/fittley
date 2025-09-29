<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FitNewsResource extends JsonResource
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
            'channel_name' => $this->channel_name,
            'viewer_count' => $this->viewer_count,
            
            // Scheduling
            'scheduled_at' => $this->scheduled_at?->toISOString(),
            'started_at' => $this->started_at?->toISOString(),
            'ended_at' => $this->ended_at?->toISOString(),
            
            // Media
            'thumbnail' => $this->getThumbnailUrl(),
            
            // Streaming configuration
            'streaming_config' => $this->streaming_config,
            
            // Recording
            'recording' => [
                'enabled' => $this->recording_enabled,
                'url' => $this->recording_url,
                'status' => $this->recording_status,
                'duration' => $this->recording_duration,
                'file_size' => $this->recording_file_size,
            ],
            
            // Relationships
            'creator' => $this->whenLoaded('creator', function () {
                return [
                    'id' => $this->creator->id,
                    'name' => $this->creator->name,
                    'avatar' => $this->creator->avatar ?? null,
                ];
            }),
            
            // Status helpers
            'is_live' => $this->status === 'live',
            'is_upcoming' => $this->status === 'scheduled' && $this->scheduled_at > now(),
            'is_archived' => $this->status === 'ended',
            'can_watch' => $this->status === 'live' || ($this->status === 'ended' && $this->recording_url),
            
            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    /**
     * Get thumbnail URL
     */
    private function getThumbnailUrl(): ?string
    {
        if (!$this->thumbnail) {
            return null;
        }

        if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
            return $this->thumbnail;
        }

        return Storage::url($this->thumbnail);
    }
}
