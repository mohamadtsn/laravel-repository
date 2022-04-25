<?php

namespace Mohamadtsn\Repository\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SampleRepository extends Repository
{

    protected function init(): Builder
    {
        // Sample
        // return User::query();
    }

    protected function instanceModel(): Model
    {
        // Sample
        // return new User();
    }

    protected function modelName(): string
    {
        // Sample
        return 'User';
    }
}