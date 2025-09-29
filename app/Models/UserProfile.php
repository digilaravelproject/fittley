<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'body_fat_percentage',
        'chest_measurement',
        'waist_measurement',
        'hips_measurement',
        'arms_measurement',
        'thighs_measurement',
        'interests',
        'fitness_goals',
        'activity_level',
        'bio',
        'location',
        'date_of_birth',
        'show_body_stats',
        'show_goals',
        'show_interests',
        'profile_visibility',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'body_fat_percentage' => 'decimal:2',
        'chest_measurement' => 'decimal:2',
        'waist_measurement' => 'decimal:2',
        'hips_measurement' => 'decimal:2',
        'arms_measurement' => 'decimal:2',
        'thighs_measurement' => 'decimal:2',
        'interests' => 'array',
        'fitness_goals' => 'array',
        'date_of_birth' => 'date',
        'show_body_stats' => 'boolean',
        'show_goals' => 'boolean',
        'show_interests' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('profile_visibility', 'public');
    }

    public function scopeByActivityLevel($query, $level)
    {
        return $query->where('activity_level', $level);
    }

    public function scopeWithInterest($query, $interest)
    {
        return $query->whereJsonContains('interests', $interest);
    }

    public function scopeWithGoal($query, $goal)
    {
        return $query->whereJsonContains('fitness_goals', $goal);
    }

    // Accessors
    public function getBmiAttribute()
    {
        if (!$this->height || !$this->weight) {
            return null;
        }
        
        $heightInMeters = $this->height / 100;
        return round($this->weight / ($heightInMeters * $heightInMeters), 2);
    }

    public function getBmiCategoryAttribute()
    {
        $bmi = $this->bmi;
        
        if (!$bmi) return null;
        
        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal weight';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }

    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }
        
        return $this->date_of_birth->age;
    }

    public function getFormattedInterestsAttribute()
    {
        if (!$this->interests) return '';
        
        return implode(', ', $this->interests);
    }

    public function getFormattedGoalsAttribute()
    {
        if (!$this->fitness_goals) return '';
        
        return implode(', ', $this->fitness_goals);
    }

    // Methods
    public function isVisibleTo($viewerId)
    {
        if ($this->user_id === $viewerId) {
            return true;
        }
        
        switch ($this->profile_visibility) {
            case 'public':
                return true;
            case 'friends':
                return Friendship::areFriends($this->user_id, $viewerId);
            case 'private':
                return false;
            default:
                return false;
        }
    }

    public function canViewBodyStats($viewerId)
    {
        return $this->show_body_stats && $this->isVisibleTo($viewerId);
    }

    public function canViewGoals($viewerId)
    {
        return $this->show_goals && $this->isVisibleTo($viewerId);
    }

    public function canViewInterests($viewerId)
    {
        return $this->show_interests && $this->isVisibleTo($viewerId);
    }
} 