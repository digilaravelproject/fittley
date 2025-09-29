<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FitArenaEventResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'event_type' => $this->event_type,
            
            // Scheduling
            'start_date' => $this->start_date?->toISOString(),
            'end_date' => $this->end_date?->toISOString(),
            'timezone' => $this->timezone,
            
            // Media
            'banner_image' => $this->getBannerImageUrl(),
            'logo' => $this->getLogoUrl(),
            
            // Settings
            'is_featured' => $this->is_featured,
            'max_participants' => $this->max_participants,
            'registration_required' => $this->registration_required,
            'registration_deadline' => $this->registration_deadline?->toISOString(),
            
            // DVR settings
            'dvr_enabled' => $this->dvr_enabled,
            'dvr_duration_hours' => $this->dvr_duration_hours,
            
            // Stages
            'stages' => $this->whenLoaded('stages', function () {
                return $this->stages->map(function ($stage) {
                    return [
                        'id' => $stage->id,
                        'name' => $stage->name,
                        'description' => $stage->description,
                        'sort_order' => $stage->sort_order,
                        'is_active' => $stage->is_active,
                        'stream_url' => $stage->stream_url,
                    ];
                });
            }),
            
            // Sessions
            'sessions' => $this->whenLoaded('sessions', function () {
                return $this->sessions->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'title' => $session->title,
                        'description' => $session->description,
                        'start_time' => $session->start_time?->toISOString(),
                        'end_time' => $session->end_time?->toISOString(),
                        'stage_id' => $session->stage_id,
                        'speaker' => $session->speaker,
                        'session_type' => $session->session_type,
                        'is_live' => $session->is_live,
                    ];
                });
            }),
            
            // Agenda (if loaded)
            'agenda' => $this->when($this->relationLoaded('agenda'), function () {
                return $this->agenda->groupBy('date')->map(function ($dayAgenda, $date) {
                    return [
                        'date' => $date,
                        'sessions' => $dayAgenda->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'time' => $item->start_time?->format('H:i'),
                                'title' => $item->title,
                                'speaker' => $item->speaker,
                                'stage' => $item->stage->name ?? null,
                                'duration' => $item->duration_minutes,
                            ];
                        }),
                    ];
                });
            }),
            
            // Status helpers
            'is_live' => $this->status === 'live',
            'is_upcoming' => $this->status === 'scheduled' && $this->start_date > now(),
            'is_ended' => $this->status === 'ended',
            'is_ongoing' => $this->start_date <= now() && $this->end_date >= now(),
            'can_register' => $this->registration_required && 
                            $this->registration_deadline > now() && 
                            $this->status !== 'ended',
            
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

    /**
     * Get logo URL
     */
    private function getLogoUrl(): ?string
    {
        if (!$this->logo) {
            return null;
        }

        if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
            return $this->logo;
        }

        return Storage::url($this->logo);
    }
}
