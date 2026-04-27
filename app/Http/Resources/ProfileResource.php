<?php

namespace App\Http\Resources;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'full_name' => $this->whenLoaded('user', fn() => $this->user?->full_name),
            'member_since' => $this->whenLoaded('user', fn() => $this->user?->member_since),
            'email' => $this->whenLoaded('user', fn() => $this->user?->email),

            'rating' => $this->rating,
                      'reviews'=>  $this->whenLoaded('reviews', fn() => $this->reviews->map(fn($review) => [
                      'by'=>User::findOrFail($review->client_id)->full_name,
                      'comment' => $review->comment,
                         'rate' => $review->rate,
                            'created_at' => $review->created_at,
                            ])),

            'bio' => $this->bio,

            'hourly_rate' => $this->hourly_rate,
            'phone_number' => $this->phone_number,

            'portfolio_links' => $this->portfolio_links ?? [],

            'skills_summary' => $this->whenLoaded('skills', fn() => $this->skills->map(fn($skill) => [
                'name' => $skill->name,
                'experience_years' => $skill->pivot->experience_years,
            ])),

            'availability_status' => $this->availability_status,
            'avatar_url' => $this->avatar_url,



        ];
    }
}
