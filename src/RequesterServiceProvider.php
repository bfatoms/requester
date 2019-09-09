<?php

namespace BfAtoms\Requester;

use Illuminate\Support\ServiceProvider;

class RequesterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('BfAtoms\Requester\Requester');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
