<?php

namespace Mohamadtsn\Repository\Traits;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use \Mohamadtsn\Repository\Contracts\Repository as abstractRepositories;
use RuntimeException;

trait Repository
{
    private string $classUser;
    private string|null $repositoryName;

    /**
     * @return void
     */
    private function setOriginClass(): void
    {
        if (empty($this->classUser)) {
            $this->classUser = static::class;
        }
    }


    /**
     * @param string|null $name
     * @throws Exception
     */
    private function setRepositoryName(string $name = null): void
    {
        if (!empty($name)) {
            $this->repositoryName = $name . 'Repository';
            if (!app()->bound($this->repositoryName)) {
                throw new RuntimeException('Not bound class in Service Container.');
            }
            return;
        }

        $this->repositoryName = method_exists($this->classUser, 'getName') ?
            (call_user_func([$this->classUser, 'getName']) . 'Repository') : null;

        if (empty($this->repositoryName)) {
            throw new RuntimeException('Not Used "RepositoryProvisions" this Controller Or Not Exist desired controller.');
        }

        if (!app()->bound($this->repositoryName)) {
            throw new RuntimeException('Not bound "' . $this->repositoryName . '" in Service Container.');
        }
    }


    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        return $this->resolve()->$name(...$arguments);
    }


    /**
     * @param string|null $name
     * @return Application|mixed
     * @throws Exception
     */
    private function resolve(string|null $name = null): mixed
    {
        $this->setOriginClass();
        $this->setRepositoryName($name ?? null);
        return app($this->repositoryName);
    }


    /**
     * @param string|null $name
     * @return Application|abstractRepositories
     * @throws Exception
     */
    public function repository(string $name = null): abstractRepositories|Application
    {
        return $this->resolve($name);
    }
}
