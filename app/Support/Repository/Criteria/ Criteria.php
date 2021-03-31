<?php

namespace Bill\Support\Repository\Criteria;

use Illuminate\Database\Eloquent\Model;

abstract class Criteria
{
    /**
     * Add a new select array to query.
     *
     * @return array
     */
    abstract public function select();

    /**
     * Add a criteria to query results.
     *
     * @param $model
     * @return Model
     */
    abstract public function apply($model);
}
