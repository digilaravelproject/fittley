<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FitInsightResource extends JsonResource
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
            'excerpt' => $this->excerpt,
            'content' => $this->when($request->routeIs('*.show'), $this->content),
            'status' => $this->status,
            'reading_time' => $this->reading_time,
            'tags' => $this->tags,
            
            // Publishing
            'published_at' => $this->published_at?->toISOString(),
            'scheduled_at' => $this->scheduled_at?->toISOString(),
            
            // Media
            'featured_image' => $this->getFeaturedImageUrl(),
            'social_image' => $this->getSocialImageUrl(),
            
            // SEO
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
                'keywords' => $this->meta_keywords,
                'canonical_url' => $this->canonical_url,
            ],
            
            // Social
            'social' => [
                'title' => $this->social_title,
                'description' => $this->social_description,
            ],
            
            // Stats
            'stats' => [
                'views_count' => $this->views_count,
                'likes_count' => $this->likes_count,
                'shares_count' => $this->shares_count,
            ],
            
            // Settings
            'is_featured' => $this->is_featured,
            'is_trending' => $this->is_trending,
            'allow_comments' => $this->allow_comments,
            'sort_order' => $this->sort_order,
            
            // Relationships
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug ?? null,
                ];
            }),
            'author' => $this->whenLoaded('author', function () {
                return [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                    'avatar' => $this->author->avatar ?? null,
                ];
            }),
            
            // Status helpers
            'is_published' => $this->status === 'published',
            'is_draft' => $this->status === 'draft',
            'is_scheduled' => $this->status === 'scheduled',
            
            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    /**
     * Get featured image URL
     */
    private function getFeaturedImageUrl(): ?string
    {
        if (!$this->featured_image_path) {
            return null;
        }

        if (filter_var($this->featured_image_path, FILTER_VALIDATE_URL)) {
            return $this->featured_image_path;
        }

        return Storage::url($this->featured_image_path);
    }

    /**
     * Get social image URL
     */
    private function getSocialImageUrl(): ?string
    {
        if (!$this->social_image_path) {
            return null;
        }

        if (filter_var($this->social_image_path, FILTER_VALIDATE_URL)) {
            return $this->social_image_path;
        }

        return Storage::url($this->social_image_path);
    }
}
