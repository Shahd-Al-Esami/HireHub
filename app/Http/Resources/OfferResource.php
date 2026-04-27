<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
'id'=>$this->id,
'freelancer_name'=> $this->whenLoaded('user', fn() => $this->user?->full_name),
'cover_letter'=>$this->cover_letter,
'price'=>$this->price,
'delivery_time'=>$this->delivery_time,
'status'=>$this->status,

];
    }
}
