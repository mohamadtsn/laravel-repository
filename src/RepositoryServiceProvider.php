<?php

namespace Mohamadtsn\Repository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerCommands();

        $this->publishes([
            __DIR__ . '/Providers' => base_path('app/Providers/'),
            __DIR__ . '/Repositories' => base_path('app/Repositories/'),

        ], 'repository-config');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            Commands\RepositoryMakeCommand::class,
        ]);
    }
}