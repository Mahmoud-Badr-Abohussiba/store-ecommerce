<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

class Repository implements \App\Http\Interfaces\RepositoryInterface
{

    protected $model;

    // constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model  = $model;
    }

    public function all()
    {
       return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create([$data]);
    }

    public function update(array $data, $id)
    {
       $record = $this->find($id);
       return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function show($id)
    {
        return $this->model;
    }
}
