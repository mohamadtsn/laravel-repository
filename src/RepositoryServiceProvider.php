<?php

namespace Mohamadtsn\Repository;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use SplFileInfo;

class RepositoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerCommands();

        $this->publishes([
            __DIR__ . '/Repositories' => base_path('app/Repositories/'),

        ], 'repository-config');
    }

    public function register()
    {
        $this->getAllClassRepositories()->each(function ($repository) {
            if (!$this->app->bound($repository)) {
                $this->app->singleton($repository, fn() => new $repository);
            }
        });
    }

    private function getAllClassRepositories(): Collection
    {
        $repository_path = app_path('Repositories');
        $repositories = collect();
        if (File::isDirectory($repository_path)) {
            $repositories = collect(File::files($repository_path))
                ->skip(2)
                ->map(fn(SplFileInfo $repository) => ('App\\Repositories\\' . str($repository->getBasename())->remove('.php')));
        }

        return $repositories;
    }

    protected function registerCommands(): void
    {
        $this->commands([
            Commands\RepositoryMakeCommand::class,
        ]);
    }
}