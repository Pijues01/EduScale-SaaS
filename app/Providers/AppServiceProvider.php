<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Share user data with all views
         View::composer('*', function ($view) {
            $user = Auth::check() ? User::where('unique_id', Auth::id())->first() : null;
            $view->with('user', $user);
        });
    }
}
