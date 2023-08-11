<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try{
            $settings = Setting::where('id', '=', 1)->get();

            View::composer('*', function ($view) use ($settings) {
                $view->with('settings', $settings);
            });
        } catch (\Exception $e) {
            return;
        }
    }


}
