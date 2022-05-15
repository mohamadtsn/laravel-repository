<?php

namespace Mohamadtsn\Repository\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SampleRepository extends Repository
{

    public function init(): Builder
    {
        // Sample
        // return User::query();
    }

    public function instanceModel(): Model
    {
        // Sample
        // return new User();
    }

    public static function modelName(): string
    {
        // Sample
        return 'User';
    }
}