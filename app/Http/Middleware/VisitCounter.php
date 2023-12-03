<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Facades\Agent;

class VisitCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $visit = new Visit();
        $visit->ip = $_SERVER['REMOTE_ADDR'];
        $visit->date = Verta::now();
        $visit->url = url()->full();
        $visit->save();
        return $next($request);
    }
}
