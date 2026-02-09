<?php

namespace OrchidBuilder;

use Illuminate\Support\ServiceProvider;
class OrchidBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/orchid-common.php' => config_path('orchid-common.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/orchid-common.php', 'orchid-common'
        );
    }
}