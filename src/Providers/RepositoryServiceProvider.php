<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // +|i|+ => register Repositories    --help
        $this->app->singleton('SampleRepository' /* enter Repository class name */, static function () {
            // +|i|+ => new instance from Repository    --help

            // return new SampleRepository();
        });
    }
}
