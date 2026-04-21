<?php

namespace App\Models;

use App\Models\Attachment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{ use SoftDeletes;
    protected $fillable = ['status','cover_letter','price','delivery_time','project_id','freelancer_id'];
      public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
        public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
     public function user()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}
