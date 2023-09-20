<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('unique_kamar_in_kos', function ($attribute, $value, $parameters, $validator) {
            list($kostId) = $parameters;
        
            return \DB::table('kamar')
                ->where('no_kamar', $value)
                ->where('lokasi_id', $kostId)
                ->count() === 0;
        });

        
        Paginator::useBootstrap();
    }
}
