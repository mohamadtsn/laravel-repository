<?php

namespace Mohamadtsn\Repository\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Mohamadtsn\Repository\Contracts\Repository as RepositoryContract;
use RuntimeException;

trait Repository
{
    private string $classUser;
    private ?string $repositoryName = null;

    /**
     * Magic method to handle dynamic method calls to the resolved repository.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws RuntimeException
     */
    public function __call($name, $arguments)
    {
        return $this->resolve()->$name(...$arguments);
    }

    /**
     * Resolves the repository instance from the service container.
     *
     * @param string|null $name
     * @return mixed
     * @throws RuntimeException
     */
    private function resolve(?string $name = null): mixed
    {
        $this->setOriginClass();
        $this->setRepositoryName($name);

        try {
            return app($this->repositoryName);
        } catch (BindingResolutionException $e) {
            throw new RuntimeException("Failed to resolve repository: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Sets the origin class for the repository.
     *
     * @return void
     */
    private function setOriginClass(): void
    {
        $this->classUser = $this->classUser ?? static::class;
    }

    /**
     * Sets the repository name based on the provided name or the class user.
     *
     * @param string|null $name
     * @return void
     * @throws RuntimeException
     */
    private function setRepositoryName(?string $name = null): void
    {
        if ($name !== null) {
            $this->repositoryName = "App\\Repositories\\{$name}Repository";
            $this->validateRepositoryBinding();
            return;
        }

        $this->repositoryName = $this->getRepositoryNameFromClass();
        $this->validateRepositoryName();
        $this->validateRepositoryBinding();
    }

    /**
     * Validates if the repository is bound in the service container.
     *
     * @return void
     * @throws RuntimeException
     */
    private function validateRepositoryBinding(): void
    {
        if (!app()->bound($this->repositoryName)) {
            throw new RuntimeException("'{$this->repositoryName}' is not bound in the Service Container.");
        }
    }

    /**
     * Retrieves the repository name from the class user.
     *
     * @return string|null
     */
    private function getRepositoryNameFromClass(): ?string
    {
        if (method_exists($this->classUser, 'getName')) {
            return "App\\Repositories\\" . call_user_func([$this->classUser, 'getName']) . "Repository";
        }
        return null;
    }

    /**
     * Validates if the repository name is set.
     *
     * @return void
     * @throws RuntimeException
     */
    private function validateRepositoryName(): void
    {
        if (empty($this->repositoryName)) {
            throw new RuntimeException('RepositoryProvisions not used in this Controller or desired controller does not exist.');
        }
    }

    /**
     * Returns the repository instance.
     *
     * @param string|null $name
     * @return RepositoryContract
     * @throws RuntimeException
     */
    public function repository(?string $name = null): RepositoryContract
    {
        return $this->resolve($name);
    }
}