<?php
namespace App\Actions\Admins;

use App\Models\Offer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardStats{

public function getStats()
{
   $stats = DB::table('users')
            ->selectRaw("
                COUNT(*) as total_users,
                COUNT(CASE WHEN role = 'freelancer' THEN 1 END) as total_freelancers,
                COUNT(CASE WHEN role = 'client' THEN 1 END) as total_clients,
                (SELECT COUNT(*) FROM projects) as total_projects,
                (SELECT COUNT(*) FROM offers) as total_offers,
                (SELECT SUM(price) FROM offers) as total_offers_value
            ")
            ->first();
    return [
        'total_users' => $stats->total_users,
        'total_freelancers' => $stats->total_freelancers,
        'total_clients' => $stats->total_clients,
        'total_projects' => $stats->total_projects,
        'total_offers' => $stats->total_offers,
        'total_offers_value' => $stats->total_offers_value
    ];
}
}
