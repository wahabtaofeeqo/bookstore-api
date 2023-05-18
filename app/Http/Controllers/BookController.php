<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepository;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Auth;

class BookController extends Controller
{
    /**
     * property
     */
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->repository->read();
        return $this->paginatedResponse('Books', $paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $payload = $request->validated();

        $author = Auth::user()->author;
        $payload['author_id'] = $author->id;

        // create
        $model = $this->repository->create($payload);

        //
        return $this->okResponse('Book created successfully', $model);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = $this->repository->get($id);
        if($model) return $this->okResponse('Book', $model);
        else return $this->errResponse('Book does not exist');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $payload = $request->validated();

        $model = $this->repository->get($id);
        if(!$model) return $this->errResponse('Book does not exist');

        $author = Auth::user()->author;
        if($model->author_id != $author->id)
            return $this->errResponse('Operation not allowed');

        $model = $this->repository->update($id, $payload);
        return $this->okResponse('Book updated successfully', $model);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = $this->repository->get($id);
        if(!$model) return $this->errResponse('Book does not exist');

        $author = Auth::user()->author;
        if($model->author_id != $author->id)
            return $this->errResponse('Operation not allowed');

        $model = $this->repository->delete($id);
        return $this->okResponse('Book updated successfully', $model);
    }
}
