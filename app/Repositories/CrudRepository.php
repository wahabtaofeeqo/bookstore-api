<?php

namespace App\Repositories;

abstract class CrudRepository
{
    /**
     * @property Model $model
     *
     */
    public $model;

    public function create($data)
    {
        return $this->model::create($data);
    }

    public function read($limit = 10)
    {
        return $this->model::latest()->paginate($limit);
    }

    public function update($id, $data)
    {
        $model = $this->get($id);
        if ($model) {
            $model->fill($data);
            $model->save();
            return $model;
        }

        throw new \Exception("Model ID not recognized", 404);
    }

    public function delete($id)
    {
        $model = $this->get($id);
        if ($model) {
            $model->delete();
            return $model;
        }

        throw new \Exception("Model not found", 404);
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function findBy($option = [], $relation = [])
    {
        return $this->model::with($relation)->where($option)->first();
    }
}
