<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends CrudRepository
{
    public function __construct()
    {
        $this->model = User::class;
    }
}
