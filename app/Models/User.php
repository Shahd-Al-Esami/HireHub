<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use App\Enums\UserRoleEnum;
use App\Models\City;
use App\Models\Country;
use App\Models\Offer;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Review;
use App\Models\Skill;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'city_id',
        'is_verified',
        'is_active'
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
             'is_verified' => 'boolean',
             'is_active' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRoleEnum::class,
        ];
    }

       /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

  // هذه الحقول ستُحسب تلقائياً وتُضاف لرد الـ JSON
    protected $appends = [
        'full_name',


        'member_since'
    ];


//////////////accessor
     protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? $this->name)),
        );
    }



  protected function memberSince(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Member since ' . $this->created_at->format('F Y'),
        );
    }



    //////////secure mutator
 protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => !empty($value) && !str_starts_with($value, '$2y$')
                ? Hash::make($value)
                : $value
        );
    }


/////////////////scops
  public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFreelancers(Builder $query)
    {
        return $query->where('role', UserRoleEnum::FREELANCER->value);
    }
 public function scopeVerified(Builder $query)
    {
        return $query->where('is_verified', true);
    }








       public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

     public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

     public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }



     public function city():BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country():HasOneThrough
    {
        return $this->hasOneThrough(Country::class, City::class);
    }


      public function freelanserOffers():HasManyThrough
    {
        return $this->hasManyThrough(Project::class, Offer::class);
    }

}
