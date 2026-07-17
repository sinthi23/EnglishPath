<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Define default password rules
        \Illuminate\Validation\Rules\Password::defaults(function () {
            return \Illuminate\Validation\Rules\Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        if ($this->app->runningInConsole()) {
            return;
        }

        $request = request();

        $themePreference = $request->cookie('theme', 'light');
        $languagePreference = $request->cookie('preferred_language', config('app.locale'));
        $dashboardLayoutPreference = $request->cookie('dashboard_layout', 'comfortable');

        if (! in_array($themePreference, ['light', 'dark'], true)) {
            $themePreference = 'light';
        }

        if (! in_array($languagePreference, ['en', 'bn'], true)) {
            $languagePreference = config('app.locale');
        }

        if (! in_array($dashboardLayoutPreference, ['comfortable', 'compact'], true)) {
            $dashboardLayoutPreference = 'comfortable';
        }

        app()->setLocale($languagePreference);

        View::share([
            'themePreference' => $themePreference,
            'languagePreference' => $languagePreference,
            'dashboardLayoutPreference' => $dashboardLayoutPreference,
        ]);
    }
}
