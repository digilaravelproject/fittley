<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HomepageHero extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'youtube_video_id',
        'play_button_text',
        'play_button_link',
        'trailer_button_text',
        'trailer_button_link',
        'category',
        'duration',
        'year',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'year' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Scope for active heroes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Get YouTube embed URL
     */
    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->youtube_video_id) {
            return null;
        }
        return "/storage/app/public/fitdoc/videos/124251-730508536.mp4";
    }

    /**
     * Get YouTube thumbnail URL
     */
    public function getYoutubeThumbnailUrlAttribute()
    {
        if (!$this->youtube_video_id) {
            return null;
        }
        return "/storage/app/public/fitdoc/banners/LK1MNV6lD809Z8pAgV6k6hokAKEJnZiDT9JDsR1m.jpg";
    }

    /**
     * Extract YouTube video ID from URL
     */
    public static function extractYoutubeId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}
