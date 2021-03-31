<?php

namespace App\Support\Repository\Eloquent;

use App\Support\Repository\Contracts\RepositoryInterface;
use App\Support\Repository\Criteria\Criteria;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;

abstract class Repository implements RepositoryInterface
{
    /**
     * Model instance.
     *
     * @var Model|Builder
     */
    private $model;

    /**
     * App instance.
     *
     * @var App
     */
    private $app;

    /**
     * Models per page.
     *
     * @var int
     */
    public $perPage = 25;

    /**
     * Set true if model use soft deletes.
     * When softdeletes is true, on delete deleted_at attribute is filled with a datetime value
     * and global queries receive a basic criteria that remove deleted models from the list.
     *
     * @var bool
     */
    public $softDeletes = false;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * Model select attributes.
     *
     * @var Collection
     */
    protected $select;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->app = app();
        $this->criteria = new Collection();

        // create and set default attribute.
        $this->select = new Collection();

        $this->setInstance();
        $this->applyGlobalCriteria();
    }

    /**
     * Get a model attribute by name.
     *
     * @param $name
     * @return mixed
     */
    public function attr($name)
    {
        if (! property_exists($this, $name)) {
            return $this->model->$name;
        }

        return $this->$name;
    }

    /**
     * Model class.
     *
     * @return string
     */
    abstract public function model();

    /**
     * Get a fresh model instance.
     *
     * @return Model
     */
    public function getInstance()
    {
        $this->setInstance();
        return $this->model;
    }

    /**
     * A alias to self getInstance().
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->getInstance();
    }

    /**
     * Get all models.
     * @return Collection
     */
    public function all()
    {
        return $this->fetch('all');
    }

    /**
     * Sort model results.
     *
     * @param $sort
     * @param $order
     * @return $this
     */
    public function orderBy($sort, $order)
    {
        $this->model = $this->model->orderBy($sort, $order);
        return $this;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->fetch('paginate');
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->fetch('first');
    }

    /**
     * @return mixed
     */
    public function toSql()
    {
        return $this->fetch('toSql');
    }

    /**
     * Find a model.
     *
     * @param $id
     * @return Model
     */
    public function find($id)
    {
        $attribute['id'] = $id;
        return $this->model = $this->fetch('find', $attribute);
    }

    /**
     * Add a basic criteria to query a model.
     *
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'AND')
    {
        $this->model = $this->model->where($column, $operator, $value, $boolean);
        return $this;
    }

    /**
     * Create a new model.
     *
     * @param $attributes
     * @return Model
     */
    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update a model.
     *
     * @param $attributes array
     * @param $id
     * @param bool $useMassAssign
     * @return bool
     */
    public function update($attributes, $id, $useMassAssign = true)
    {
        $model = $this->find($id);

        if (!$useMassAssign) {
            foreach ($attributes as $k => $v) {
                $model->$k = $v;
            }
            return $model->save();
        }

        return $model->update($attributes);
    }

    /**
     * Delete a model by id.
     *
     * @param $ids array|int
     * @return bool
     */
    public function delete($ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Instantiate a model.
     *
     * @throws \Exception
     */
    private function setInstance()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Model must be a instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $model;
    }

    /**
     * Receive a User criteria, treat and request inclusion into internal criteria list.
     *
     * @return $this
     */
    public function pushCriteria()
    {
        if (func_num_args() === 0) {
            return $this;
        }

        $list = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

        $this->addCriteria($list);
        return $this;
    }

    /**
     * Process received criteria.
     *
     * Add received criteria
     * @param array $criteria
     */
    private function addCriteria(array $criteria)
    {
        foreach ($criteria as $item) {
            if ($this->criteria->search($item) === false) {
                $this->criteria->push($item);
            }
        }
    }

    /**
     * Apply criteria.
     */
    private function applyCriteria()
    {
        foreach ($this->criteria as $criteria) {
            if (method_exists($criteria, 'select')) {
                $this->addSelect($criteria->select());
            }

            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model);
            }
        }
    }

    /**
     * Apply model global criteria.
     */
    private function applyGlobalCriteria()
    {
        if (property_exists($this->model, 'globalCriteria') && count($this->model->globalCriteria) > 0) {
            $this->pushCriteria($this->model->globalCriteria);
        }
    }

    /**
     * Fetch models results by method. Methods can be: find, paginate or get.
     *
     * @param $method
     * @param null $attributes
     * @return mixed
     */
    private function fetch($method, $attributes = null)
    {
        // remove deleted model that use softDeletes.
        if ($this->softDeletes) {
            $this->model = $this->model->whereNull('deleted_at');
        }

        // apply all existing criteria.
        $this->applyCriteria();

        // add select attributes.
        $select = $this->select->isEmpty() ? ['*'] : $this->select->all();
        $this->model->select($select);

        // find a method by id attribute.
        if ($method == 'find') {
            return $this->model = $this->model->find($attributes['id']);
        }

        // get first model based on specified criteira.
        if ($method == 'first') {
            return $this->model = $this->model->first();
        }

        // paginate model results.
        if ($method == 'paginate') {
            return $this->model = $this->model->paginate($this->perPage);
        }

        // get all models.
        if ($method == 'all') {
            return $this->model = $this->model->get();
        }

        // paginate model results.
        if ($method == 'toSql') {
            return $this->model->toSql();
        }

        return $this->model;
    }

    /**
     * Push a new attribute to select.
     *
     * @param array $select
     * @return $this
     */
    public function addSelect(array $select)
    {
        foreach ($select as $item) {
            if ($this->select->search($item) == false) {
                $this->select->push($item);
            }
        }

        return $this;
    }

    /**
     * Call model attributes magically.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->attr($name);
    }

    /**
     * Reset repository instance.
     *
     * @return static
     */
    public function reset()
    {
        return new static($this);
    }

    /**
     * Count number of existing entity.
     */
    public function countTotal()
    {
        $count = $this->getModel()->select([
            \DB::raw('count(id) as total')
        ])->first();

        return $count->total;
    }
}
