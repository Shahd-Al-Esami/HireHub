<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * Get active verified freelancers with filters and sorting.
     */
    public function activeVerifiedFreelancers(Request $request): LengthAwarePaginator
    {


        $query=Profile::availableNow()->whereHas('user', fn($q) => $q->freelancers()->active()->verified())->withCount('reviews')->withAvg('reviews', 'rate');


        // Dynamic filtering
        if ($request->filled('min_rating')) {
            $query->having('reviews_avg_rate', '>=', $request->min_rating);
        }

        if ($request->filled('skill_ids')) {
            $ids = array_map('intval', explode(',', $request->skill_ids));
            $query->whereHas('skills', fn($q) => $q->whereIn('skills.id', $ids));
        }

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
    }
}
