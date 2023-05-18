<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository extends CrudRepository
{
    public function __construct()
    {
        $this->model = Book::class;
    }
}
