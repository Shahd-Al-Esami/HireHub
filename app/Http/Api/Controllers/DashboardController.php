<?php

namespace App\Http\Api\Controllers;
use App\Actions\Admins\DashboardStats;
use App\Http\Api\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(DashboardStats $dashboardStats)
    {
        return response()->json($dashboardStats->getStats());
    }
}
