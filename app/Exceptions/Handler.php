<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Status code
        $status =  $exception->getCode() ??  400;
        if(!is_int($status) || $status <= 0) $status = 400;

        // Exception type
        if ($exception instanceof AuthenticationException) $status = 401;
        if ($exception instanceof NotFoundHttpException
            || $exception instanceof NotFoundResourceException) $status = 404;


        // Data
        $responseData = [
            'status' => false,
            'message' => $exception->getMessage() ?? 'Operation not succeeded',
        ];

        if (config('app.debug')) {
            $responseData['stack_trace'] = $exception->getTrace();
        }

        //
        return response()->json($responseData, $status);
    }
}
