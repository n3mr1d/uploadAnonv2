<?php

namespace App\Providers;

use App\Models\Visitor;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Event::listen('Illuminate\Routing\Events\RouteMatched', function ($event) {
            Visitor::create([
                'ip_user' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
