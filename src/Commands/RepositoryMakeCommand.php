<?php

namespace Mohamadtsn\Repository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    public function handle()
    {
        if (!$this->option('model')) {
            $this->error('The "model" param is required.');
            $this->warn('example: --model=User');

            return false;
        }
        return parent::handle();
    }

    /**
     * @param $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceModel($stub)->replaceClass($stub, $name);
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, rtrim(__DIR__, '/') . '/stubs/repository.stub');
    }

    protected function replaceModel(&$stub)
    {
        $modelClass = $this->parseModel($this->option('model'));

        $stub = str_replace([
            '{{ model }}',
            '{{ namespacedModel }}',
        ], [
            class_basename($modelClass),
            $modelClass,
        ], $stub);

        return $this;
    }

    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    protected function getOptions()
    {
        return [
            ['model=', 'm=', InputOption::VALUE_REQUIRED, 'Set model in new repository'],
        ];
    }
}
