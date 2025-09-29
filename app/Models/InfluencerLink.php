<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InfluencerLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'influencer_profile_id',
        'link_code',
        'campaign_name',
        'description',
        'target_url',
        'clicks_count',
        'conversions_count',
        'conversion_rate',
        'is_active',
        'expires_at',
        'tracking_params',
    ];

    protected $casts = [
        'influencer_profile_id' => 'integer',
        'clicks_count' => 'integer',
        'conversions_count' => 'integer',
        'conversion_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'tracking_params' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($link) {
            if (empty($link->link_code)) {
                $link->link_code = static::generateUniqueCode();
            }
        });
    }

    public function influencerProfile()
    {
        return $this->belongsTo(InfluencerProfile::class);
    }

    public function sales()
    {
        return $this->hasMany(InfluencerSale::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('link_code', $code);
    }

    public function isActive()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }

        return true;
    }

    public function incrementClicks()
    {
        $this->increment('clicks_count');
        $this->updateConversionRate();
    }

    public function incrementConversions()
    {
        $this->increment('conversions_count');
        $this->updateConversionRate();
    }

    public function updateConversionRate()
    {
        if ($this->clicks_count > 0) {
            $rate = ($this->conversions_count / $this->clicks_count) * 100;
            $this->update(['conversion_rate' => round($rate, 2)]);
        }
    }

    public function getFullUrlAttribute()
    {
        $baseUrl = config('app.url');
        return $baseUrl . '/r/' . $this->link_code;
    }

    public static function generateUniqueCode($length = 10)
    {
        do {
            $code = Str::random($length);
        } while (static::where('link_code', $code)->exists());

        return $code;
    }

    public static function findByCode($code)
    {
        return static::where('link_code', $code)->first();
    }
} 