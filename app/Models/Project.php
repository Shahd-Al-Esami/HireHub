<?php

namespace App\Models;

use App\Enums\BudgetTypeEnum;
use App\Enums\ProjectStatusEnum;
use App\Models\Attachment;
use App\Models\Offer;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable = ['title','description','budget_amount','budget_type','status','client_id','delivery_date'];


     protected $casts = [
        'budget_amount' => 'decimal:2',
        'delivery_date' => 'date',
        'budget_type'   => BudgetTypeEnum::class,
        'status'        => ProjectStatusEnum::class,
    ];

    protected $appends = ['budget_formatted', 'left_days'];

    //////accessor
  protected function budgetFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                $amount = number_format($this->budget_amount, 0); // بدون كسور لمظهر أنظف

                if ($this->budget_type === 'hourly') {
                    return "$$amount/hr";
                }

                return "$$amount USD";
            }
        );
    }


 protected function leftDays(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (in_array($this->status, ['closed'])) {
                    return 'Delivered';
                }

                $deadline = Carbon::parse($this->delivery_date);
                $now = Carbon::now();

                if ($deadline->isPast()) {
                    return 'Expired';
                }

                $daysLeft =(int) $now->diffInDays($deadline, false); // false = لا قيمة مطلقة

                if ($daysLeft === 0) {
                    return "Due today";
                } elseif ($daysLeft === 1) {
                    return 'Expires tomorrow';
                } elseif ($daysLeft <= 7) {
                    return "Expires in $daysLeft days";
                } else {
                    return "Due in $daysLeft days";
                }
            }
        );}


////////////////scopes
 public function scopeOpenProjects(Builder $query)
    {
        return $query->where('status',ProjectStatusEnum::OPEN->value);
    }

     public function scopeMinBudget(Builder $query,$amount)
    {
        return $query->where('budget_amount','>=',$amount);
    }


       public function scopeThisMonth(Builder $query)
    {
        return $query->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()]);
    }

////////////relationships

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

      public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }



        public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'project_tags');
    }

      public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

      public function review(): MorphOne
    {
        return $this->morphOne(Review::class, 'reviewable');
    }
}
