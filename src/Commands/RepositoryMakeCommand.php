<?php

namespace Mohamadtsn\Repository\Commands;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    protected $signature = 'make:repository {name} {--model=}';
    protected $description = 'Create a new repository class';
    protected $type = 'Repository';

    public function handle()
    {
        if (!$this->option('model')) {
            $this->error('The "model" option is required.');
            $this->warn('Example: --model=User');
            return false;
        }
        return parent::handle();
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());
        return $this->replaceNamespace($stub, $name)
            ->replaceModel($stub)
            ->replaceClass($stub, $name);
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/repository.stub');
    }

    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function replaceModel(&$stub): static
    {
        $modelClass = $this->parseModel($this->option('model'));

        $replace = [
            '{{ model }}' => class_basename($modelClass),
            '{{ namespacedModel }}' => $modelClass,
        ];

        $stub = str_replace(array_keys($replace), array_values($replace), $stub);

        return $this;
    }

    protected function parseModel($model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }

    protected function getOptions(): array
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'The model that the repository will handle'],
        ];
    }
}