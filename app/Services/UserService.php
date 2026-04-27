<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class UserService
{
    /**
     * Get active verified freelancers with filters and sorting.
     */
    public function availableFreelancers(Request $request): LengthAwarePaginator
    {
//توليد مفتاح كاش بناء على الفلاتر اللي طلبناهاو على رقم الصفحة
    $params = $request->all();
    ksort($params); // ترتيب العناصر لضمان أن نفس البحث يعطي نفس المفتاح دائماً
    $cacheKey = "freelancers_available_" . md5(json_encode($params));

       $freelancers=Cache::tags(['freelancers'])->remember("freelancers_available_page_{$cacheKey}", now()->addMinutes(3),
        function () use ($request) {
        $query=Profile::availableNow()->whereHas('user', fn($q) => $q->freelancers()->active()->verified())
        ->withCount('reviews')->withAvg('reviews', 'rate');


        // Dynamic filtering

//we need to update cache when there is a new rate

        if ($request->filled('min_rating')) {
            $query->having('reviews_avg_rate', '>=', $request->min_rating);
        }
//we need to update cache when freelancer add a new skill
        if ($request->filled('skill_ids')) {
            $ids = array_map('intval', explode(',', $request->skill_ids));
            $query->whereHas('skills', fn($q) => $q->whereIn('skills.id', $ids));
        }
//we need to update cache when freelancer update his/her years experince

        if ($request->filled('min_experience')) {
            $query->whereHas('skills', fn($q) => $q->where('profile_skills.experience_years', '>=', $request->min_experience));
        }

        $sortBy = $request->query('sort_by', 'latest');
        $query = match ($sortBy) {
            'rating' => $query->orderByDesc('reviews_avg_rate'),
            'projects' => $query->orderByDesc('completed_projects_count'),
            'experience' => $query->orderByDesc('profile.experience_years'),
            default => $query->latest(),
        };

        return $query->paginate(15);
    });

        return $freelancers;
    }


}
