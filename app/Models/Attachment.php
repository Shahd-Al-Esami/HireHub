<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    protected $fillable = ['file_path','attachable_id','attachable_type','user_id'];
public function attachable(): MorphTo
{
    return $this->morphTo();
}
}
