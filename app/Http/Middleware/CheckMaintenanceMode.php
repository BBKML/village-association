<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si le mode maintenance est activé
        $maintenanceMode = Setting::getValue('maintenance_mode', false);

        // Si le mode maintenance est activé
        if ($maintenanceMode) {
            // Autoriser les administrateurs connectés
            if (Auth::check() && Auth::user()->isAdmin()) {
                return $next($request);
            }

            // Rediriger ou afficher une page de maintenance pour les autres utilisateurs
            return response()->view('errors.maintenance', [], 503);
        }

        return $next($request);
    }
}