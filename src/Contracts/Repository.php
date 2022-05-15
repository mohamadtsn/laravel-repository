<?php

namespace Mohamadtsn\Repository\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{

    abstract public function init(): Builder;
    abstract public function instanceModel(): Model;
    abstract public static function modelName(): string;

}
