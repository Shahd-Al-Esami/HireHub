<?php

namespace App\Models;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $fillable = ['name'];

       public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class,'profile_skills')->withPivot('experience_years');
    }
}
