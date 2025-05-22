<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use App\Models\User; // Importa la clase User correcta
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();
        Gate::define('viewPulse', function (?User $user) {
            return $user !== null;
        });
        // 🔒 Agrega HttpOnly a XSRF-TOKEN (opcional, si NO lo usas con JavaScript)
        app('router')->middleware('web')->group(function () {
            app('events')->listen('Illuminate\Routing\Events\RouteMatched', function () {
                $token = csrf_token();
    
                Cookie::queue(
                    new SymfonyCookie(
                        'XSRF-TOKEN',
                        $token,
                        now()->addMinutes(config('session.lifetime')),
                        '/',
                        null,
                        config('session.secure'),
                        true, // HttpOnly
                        false,
                        'Lax'
                    )
                );
            });
        });
    }
}
