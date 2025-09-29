<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FitGuideResource extends JsonResource
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
            'type' => $this->getTable() === 'fg_singles' ? 'single' : 'series',
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'language' => $this->language,
            'cost' => $this->cost,
            'release_date' => $this->release_date?->format('Y-m-d'),
            'duration_minutes' => $this->when(isset($this->duration_minutes), $this->duration_minutes),
            'total_episodes' => $this->when(isset($this->total_episodes), $this->total_episodes),
            'feedback' => $this->feedback,
            'is_published' => $this->is_published,
            
            // Media URLs
            'banner_image' => $this->getBannerImageUrl(),
            'trailer' => $this->getTrailerData(),
            'video' => $this->when(isset($this->video_type), $this->getVideoData()),
            
            // Relationships
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug ?? null,
                ];
            }),
            'sub_category' => $this->whenLoaded('subCategory', function () {
                return [
                    'id' => $this->subCategory->id,
                    'name' => $this->subCategory->name,
                    'slug' => $this->subCategory->slug ?? null,
                ];
            }),
            'instructor' => $this->whenLoaded('instructor', function () {
                return [
                    'id' => $this->instructor->id,
                    'name' => $this->instructor->name,
                    'avatar' => $this->instructor->avatar ?? null,
                ];
            }),
            
            // Episodes for series
            'episodes' => $this->when(
                $this->getTable() === 'fg_series' && $this->relationLoaded('episodes'),
                function () {
                    return $this->episodes->map(function ($episode) {
                        return [
                            'id' => $episode->id,
                            'episode_number' => $episode->episode_number,
                            'title' => $episode->title,
                            'description' => $episode->description,
                            'duration_minutes' => $episode->duration_minutes,
                            'video_url' => $episode->getVideoUrl(),
                            'is_published' => $episode->is_published,
                        ];
                    });
                }
            ),
            
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
        if (!$this->banner_image_path) {
            return null;
        }

        if (filter_var($this->banner_image_path, FILTER_VALIDATE_URL)) {
            return $this->banner_image_path;
        }

        return Storage::url($this->banner_image_path);
    }

    /**
     * Get trailer data
     */
    private function getTrailerData(): ?array
    {
        if (!$this->trailer_type) {
            return null;
        }

        $data = [
            'type' => $this->trailer_type,
        ];

        if ($this->trailer_type === 'url' && $this->trailer_url) {
            $data['url'] = $this->trailer_url;
        } elseif ($this->trailer_type === 'file' && $this->trailer_file_path) {
            $data['url'] = Storage::url($this->trailer_file_path);
        }

        return $data;
    }

    /**
     * Get video data
     */
    private function getVideoData(): ?array
    {
        if (!$this->video_type) {
            return null;
        }

        $data = [
            'type' => $this->video_type,
        ];

        if ($this->video_type === 'url' && $this->video_url) {
            $data['url'] = $this->video_url;
        } elseif ($this->video_type === 'file' && $this->video_file_path) {
            $data['url'] = Storage::url($this->video_file_path);
        }

        return $data;
    }
}
