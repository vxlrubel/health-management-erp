<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponse
{
    protected function successResponse(mixed $data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        $response = ['success' => true, 'message' => $message];

        if (! is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    protected function errorResponse(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        $response = ['success' => false, 'message' => $message];

        if (! empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    protected function paginatedResponse(ResourceCollection $collection, string $message = 'Success'): JsonResponse
    {
        return $collection->additional([
            'success' => true,
            'message' => $message,
        ])->response();
    }

    protected function createdResponse(mixed $data = null, string $message = 'Created successfully.'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    protected function deletedResponse(string $message = 'Deleted successfully.'): JsonResponse
    {
        return $this->successResponse(null, $message);
    }

    protected function notFoundResponse(string $message = 'Resource not found.'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    protected function forbiddenResponse(string $message = 'You are not authorized to perform this action.'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }
}
