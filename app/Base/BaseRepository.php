<?php

namespace App\Base;

use Closure;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository.
 */
abstract class BaseRepository
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @return string
     */
    abstract public function model();

    /**
     * BaseRepository constructor.
     *
     * @param Container $app
     *
     * @throws Exception
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->model = $this->makeModel();
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $column
     * @param null   $operator
     * @param null   $value
     * @param string $boolean
     *
     * @return mixed
     */
    public function findWhere($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model->where($column, $operator, $value, $boolean)->first();
    }

    public function findWhereOrFail($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model->where($column, $operator, $value, $boolean)->firstOrFail();
    }

    public function first()
    {
        return $this->model->first();
    }

    /**
     * @param array $columns
     *
     * @return Collection|Model[]
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * @param int    $perPage
     * @param string $orderBy
     * @param string $sortBy
     * @param array  $columns
     * @param string $pageName
     * @param null   $page
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage, string $orderBy = 'created_at', string $sortBy = 'desc', $columns = ['*'], $pageName = 'page', $page = null): LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, $sortBy)
            ->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @param array      $data
     * @param int|string $id
     *
     * @return bool
     */
    public function update(array $data, $id = null): bool
    {
        if ($id != null) {
            return $this->find($id)->update($data);
        }
        return $this->model->update($data);
    }

    public function updateWithoutId(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * @param int|string $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
    * @param int|string $id
    *
    * @return mixed
    */
    public function findorFail($id)
    {
        return $this->model->findorFail($id);
    }

    /**
     * @param int|string $id
     *
     * @return bool
     */
    public function delete($id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    /**
     * @param $relations
     *
     * @return $this
     */
    public function with($relations): self
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * @param Closure|string|array $column
     * @param null                 $operator
     * @param null                 $value
     * @param string               $boolean
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and'): self
    {
        if (!empty($column)) {
            $this->model = $this->model->where($column, $operator, $value, $boolean);
        }

        return $this;
    }

    /**
     * @param Closure|string|array $column
     * @param null                 $operator
     * @param null                 $value
     * @param string               $boolean
     *
     * @return $this
     */
    public function orWhere($column, $operator = null, $value = null, $boolean = 'and'): self
    {
        if (!empty($column)) {
            $this->model = $this->model->orWhere($column, $operator, $value, $boolean);
        }

        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @param string $boolean
     * @param bool   $not
     *
     * @return $this
     */
    public function whereIn($column, $value, $boolean = 'and', $not = false)
    {
        if (!empty($column)) {
            $this->model = $this->model->whereIn($column, $value, $boolean, $not);
        }

        return $this;
    }

    public function select(array $columns)
    {
        $this->model = $this->model->select($columns);

        return $this;
    }

    public function get()
    {
        return $this->model->get();
    }


    public function getMorphClass()
    {
        return $this->model->getMorphClass();
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    private function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $model;
    }
}
