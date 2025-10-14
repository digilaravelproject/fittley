<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'billing_cycle',
        'billing_cycle_count',
        'duration_months',
        'trial_days',
        'is_popular',
        'is_active',
        'sort_order',
        'features',
        'restrictions',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'billing_cycle_count' => 'integer',
        'trial_days' => 'integer',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'features' => 'array',
        'restrictions' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            if (empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });

        static::updating(function ($plan) {
            if ($plan->isDirty('name') && empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->hasMany(UserSubscription::class)->where('status', 'active');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 2);
    }

    public function getBillingCycleTextAttribute()
    {
        $cycle = $this->billing_cycle;
        $count = $this->billing_cycle_count;

        if ($count == 1) {
            return $cycle;
        }

        return $count . ' ' . Str::plural($cycle);
    }

    public function getFeatureListAttribute()
    {
        return $this->features ?? [];
    }

    public function getRestrictionListAttribute()
    {
        return $this->restrictions ?? [];
    }

    public function hasFeature($feature)
    {
        return in_array($feature, $this->getFeatureListAttribute());
    }

    public function getRestriction($key, $default = null)
    {
        $restrictions = $this->getRestrictionListAttribute();
        return $restrictions[$key] ?? $default;
    }
}
