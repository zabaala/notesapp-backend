<?php

namespace App\Support\Repository\Contracts;

use \Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * Get a moel attribute by name.
     *
     * @param $name
     * @return mixed
     */
    public function attr($name);

    /**
     * Get a model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getInstance();

    /**
     * Get all models.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Sort model results.
     *
     * @param $sort
     * @param $order
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function orderBy($sort, $order);

    /**
     * @return LengthAwarePaginator
     */
    public function paginate();

    /**
     * @return mixed
     */
    public function first();

    /**
     * @return mixed
     */
    public function toSql();

    /**
     * Find a model by id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id);

    /**
     * Create a new model.
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data);

    /**
     * Update a model.
     *
     * @param $id
     * @param $attributes
     * @param bool $useMassAssign
     * @return boolean
     */
    public function update($id, $attributes, $useMassAssign = true);

    /**
     * Delete a model by id.
     *
     * @param $id
     * @return boolean
     */
    public function delete($id);

    /**
     * Receive a User criteria, treat and request inclusion into internal criteria list.
     *
     * @return $this
     */
    public function pushCriteria();

    /**
     * Push a new attribute to select.
     *
     * @param array $select
     * @return $this
     */
    public function addSelect(array $select);

    /**
     * Call model attributes magically.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name);

    /**
     * Reset repository instance.
     *
     * @return static
     */
    public function reset();
}
