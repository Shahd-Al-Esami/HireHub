<?php

namespace App\Models;

use App\Enums\AvailabilityStatusEnum;
use App\Models\Review;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Profile extends Model
{
        protected $fillable = ['bio','hourly_rate','image','phone_number','portfolio_links','availability_status','skills_summary'];

        protected $casts = [
       'skills_summary' => 'array',
        'portfolio_links' => 'array',
         'availability_status' => AvailabilityStatusEnum::class,
    ];
         protected $appends = ['avatar_url','rating'];



///////////////accessors

   protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image
                ? asset('storage/' . $this->image)
                : asset('images/defaults_avatar.jpg'),
        );
    }


public function rating(): Attribute
{
    return Attribute::make(
        get: function () {
      if (!$this->reviews_avg_rate) {
            return [
                'average' => null,
                'count' => 0,
                'message' => 'No reviews yet',
            ];
        }

        return [
            'average' => round($this->reviews_avg_rate, 1),
            'count' => $this->reviews_count,
            'stars' => str_repeat('⭐', round($this->reviews_avg_rate)),
        ];    }

    );
}





////////////////mutators+accessor
     protected function phoneNumber(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => preg_replace('/\D+/', '', $value), // يحذف المسافات والرموز
            get: fn ($value) => $value ? '+' . $value : null,     // يرجع بالصيغة الموحدة
        );
    }



    public function hourlyRate(): Attribute
{
    return Attribute::make(
        get: fn ($value) => number_format($value / 100, 2),
        set: fn ($value) => (int) ($value * 100)
    );
}





///////////////scops
 public function scopeAvailableNow(Builder $query)
    {
        return $query->where('availability_status', AvailabilityStatusEnum::AVAILABLE);
    }



     public function scopeTopRated(Builder $query)
    {
        return $query->orderByDesc('reviews_avg_rate');
    }




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

         public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class,'profile_skills')->withPivot('experience_years');
    }

      public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
