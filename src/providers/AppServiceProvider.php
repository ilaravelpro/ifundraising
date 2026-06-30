<?php


/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 9/19/20, 8:18 PM
 * Copyright (c) 2020. Powered by iamir.net
 */

namespace iLaravel\iFundraising\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(ifundraising_path('config/ifundraising.php'), 'ilaravel.ifundraising');

        if($this->app->runningInConsole())
        {
            if (ifundraising('database.migrations.include', true))
                $this->loadMigrationsFrom(ifundraising_path('database/migrations'));
        }
    }

    public function register()
    {
        parent::register();
    }
}
