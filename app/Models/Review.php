<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    protected $fillable = ['rate','comment','client_id','reviewable_id','reviewable_type'];

      public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }


     public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
