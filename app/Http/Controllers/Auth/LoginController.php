<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\UserRepository;
use Hash;

class LoginController extends Controller
{
     /**
     * property
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function authenticate(LoginRequest $request)
    {
        $input = $request->validated();

        // Get model
        $user = $this->repository->findBy([
            'email' => $input['email']
        ]);

        // Check password
        if (!Hash::check($input['password'], $user->password)) {
            return $this->errResponse('Password not correct');
        }

        $data = [
            'user' => $user,
            'accessToken' => $user->createToken('access')->plainTextToken
        ];

        //
        return $this->okResponse('Login successful', $data);
    }
}
