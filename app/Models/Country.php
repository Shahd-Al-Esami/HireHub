<?php

namespace App\Models;

use App\Models\City;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    protected $fillable = ['name','code','phone_code'];

      public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
      public function users():HasManyThrough
    {
        return $this->hasManyThrough(User::class, City::class);
    }


}
