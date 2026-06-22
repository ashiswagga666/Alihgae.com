<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('isadmin', fn($user) => $user->role === 'admin');
        Gate::define('isperusahaan', fn($user) => $user->role === 'perusahaan');
        Gate::define('ispelamar', fn($user) => $user->role === 'pelamar');

        // Share site settings ke semua view
        View::composer('*', function ($view) {
            try {
                $siteSettings = SiteSetting::all()->pluck('value', 'key');
                $view->with('siteSettings', $siteSettings);
            } catch (\Exception $e) {
                $view->with('siteSettings', collect());
            }
        });
    }
}
