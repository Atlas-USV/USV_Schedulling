<?php

namespace App\Providers;

use App\Models\Evaluation;
use App\Policies\EvaluationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        Gate::policy(Evaluation::class, EvaluationPolicy::class);

         // Adaugă această parte pentru a lega utilizatorul autentificat la toate view-urile
        View::composer('*', function ($view) {
        $view->with('user', Auth::user());
    });
    }


}
