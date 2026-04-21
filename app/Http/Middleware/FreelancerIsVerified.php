<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FreelancerIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
     public function handle(Request $request, Closure $next): Response
    {
        // Before Middlewar ->
        //  the middleware ensure that the freelancer user is valiad to make this action before $request execution


        $user = Auth::user();
        if($user->role ==='freelancer' && $user->is_verified===false)
        return response()->json(['message'=> 'this action is allowed only for verified freelancers']);
        return $next($request);
    }
}



