<?php

namespace App\Http\Resources;

use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

      return [
            'id'                => $this->id,
            'title'             => $this->title,
            'description'       => $this->description,

            // ✅ استخدام whenLoaded لتجنب خطأ null إذا لم تُحمّل العلاقة
            'client'            => $this->whenLoaded('user', fn() => $this->user?->full_name ?? ''),
            'budget_formatted'  => $this->budget_formatted,
            'left_days'         => $this->left_days,

            'budget'            => [
                'type'   => $this->budget_type,
                'amount' => (float) $this->budget_amount,
            ],

            // ✅ أسماء الحقول مطابقة تماماً لما أنتجه الـ withCount / withAvg
            'offers_count'   => $this->offers_count ?? 0,
            'rating'        => $this->whenLoaded('review', fn() => $this->review->rate),
// ,             'rating'=>$this->review->rate??'',
            // ✅ تحميل آمن للعلاقات
            'tags'              => $this->whenLoaded('tags', fn() => TagResource::collection($this->tags)),
            'status'            => $this->status,
            'deadline'          => $this->delivery_date?->format('Y-m-d'),
            'created_at'        => $this->created_at?->diffForHumans(),
        ];



    }
}

