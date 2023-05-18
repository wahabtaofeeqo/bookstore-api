<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\UserRepository;
use Hash;

class RegisterController extends Controller
{
    /**
     * property
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(RegisterRequest $request)
    {
        $payload = $request->validated();
        $payload['password'] = Hash::make($payload['password']);

        // Create
        $user = $this->repository->create($payload);
        $user->author()->create(); // Author account

        $data = [
            'user' => $user,
            'accessToken' => $user->createToken('access')->plainTextToken
        ];

        return $this->okResponse('Account created successfully', $data);
    }
}
