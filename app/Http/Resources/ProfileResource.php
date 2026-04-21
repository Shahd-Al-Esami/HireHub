<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Profile;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // ✅ استخدام الـ Accessors من موديل User مباشرة
            // ملاحظة: تعمل فقط لأننا حملنا العلاقة عبر load('user:...') في الـ Action
            'full_name' => $this->whenLoaded('user', fn() => $this->user?->full_name),
            'member_since' => $this->whenLoaded('user', fn() => $this->user?->member_since),

            'email' => $this->whenLoaded('user', fn() => $this->user?->email),

            // ✅ rating يعتمد على Attribute في موديل Profile + loadAvg/loadCount
            'rating' => $this->rating,

            // ✅ reviews_count متاح تلقائياً بعد loadCount
            'reviews_count' => $this->reviews_count ?? 0,

            'bio' => $this->bio,

            // ✅ hourly_rate و phone_number يعتمدان على Accessors في Profile
            'hourly_rate' => $this->hourly_rate,
            'phone_number' => $this->phone_number,

            'portfolio_links' => $this->portfolio_links ?? [],

            // ✅ تم إصلاح الخطأ النحوي (حذف الفاصلة الزائدة هنا 👇)
            'skills_summary' => $this->skills_summary,

            'availability_status' => $this->availability_status,
            'avatar_url' => $this->avatar_url,

            // ✅ عرض كائن user كامل (سيشمل تلقائياً full_name و member_since لوجودهما في $appends)
            'user' => $this->whenLoaded('user', function () {
                // عند تحويل الموديل لمصفوفة، الـ $appends تُضاف تلقائياً
                return [
                    'id' => $this->user?->id,
                    'first_name' => $this->user?->first_name,
                    'last_name' => $this->user?->last_name,
                    'email' => $this->user?->email,
                    // الحقلين التاليين سيظهرون تلقائياً بسبب $appends في موديل User:
                    // 'full_name' => '...',
                    // 'member_since' => '...',
                ];
            }),

            // ✅ عرض المهارات مع بيانات الـ Pivot (experience_years)
            'skills' => $this->whenLoaded('skills', function () {
                return $this->skills->map(function ($skill) {
                    return [
                        'id' => $skill->id,
                        'name' => $skill->name,
                        // 👇 بيانات الـ Pivot لا تُضاف تلقائياً، نعرضها يدوياً
                        'experience_years' => $skill->pivot->experience_years ?? null,
                    ];
                })->values();
            }),
        ];
    }
}
