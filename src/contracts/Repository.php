<?php

namespace Mohamadtsn\Repository\contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{

    abstract protected function init(): Builder;
    abstract protected function instanceModel(): Model;
    abstract protected function modelName(): string;

}
