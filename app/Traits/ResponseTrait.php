<?php

namespace App\Traits;

/**
 *
 */
trait ResponseTrait
{
    public function errResponse($message, $code = 400, $error = null)
    {
        return response([
            'status' => false,
            'message' => $message,
            'error' => $error
        ], $code);
    }

    public function okResponse($message, $data = [])
    {
        return response([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public function paginatedResponse($message, $paginator)
    {
        $meta = [
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
            'next_page_url' => $paginator->nextPageUrl(),
            'previous_page_url' => $paginator->previousPageUrl(),
            'first_item' => $paginator->firstItem(),
            'last_item' => $paginator->lastItem(),
        ];

        return response([
            'status' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => $meta]);
    }
}
