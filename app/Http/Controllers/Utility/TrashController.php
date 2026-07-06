<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Services\TrashService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function __construct(
        protected TrashService $trashService,
    ) {}

    /**
     * List all trashed records.
     *
     * Retrieve all soft-deleted records across all registered modules.
     * Supports optional search filtering.
     *
     * @queryParam search string Optional search term to filter trashed records. Example: John
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $trashed = $this->trashService->getAllTrashed($request->search);

        return $this->successResponse([
            'data' => $trashed->values(),
            'total' => $trashed->count(),
        ]);
    }

    /**
     * Restore a trashed record.
     *
     * Restore a specific soft-deleted record by its model class and UUID.
     *
     * @bodyParam model string required The fully qualified model class name. Example: App\Models\Employee
     * @bodyParam uuid string required The UUID of the trashed record. Example: some-uuid
     */
    public function restore(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'uuid' => ['required', 'string'],
        ]);

        $modelClass = $request->model;

        if (! class_exists($modelClass)) {
            return $this->errorResponse('Model class not found.', 400);
        }

        $model = $this->trashService->restore($modelClass, $request->uuid);

        if (! $model) {
            return $this->notFoundResponse('Trashed record not found or already restored.');
        }

        return $this->successResponse(null, 'Record restored successfully.');
    }

    /**
     * Permanently delete a trashed record.
     *
     * Force delete a specific soft-deleted record by its model class and UUID.
     *
     * @bodyParam model string required The fully qualified model class name. Example: App\Models\Employee
     * @bodyParam uuid string required The UUID of the trashed record. Example: some-uuid
     */
    public function forceDelete(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'uuid' => ['required', 'string'],
        ]);

        $modelClass = $request->model;

        if (! class_exists($modelClass)) {
            return $this->errorResponse('Model class not found.', 400);
        }

        $deleted = $this->trashService->forceDelete($modelClass, $request->uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Trashed record not found.');
        }

        return $this->deletedResponse('Record permanently deleted.');
    }

    /**
     * Bulk restore trashed records.
     *
     * Restore multiple soft-deleted records by model class and UUIDs.
     *
     * @bodyParam model string required The fully qualified model class name. Example: App\Models\Employee
     * @bodyParam uuids string[] required Array of UUIDs of trashed records. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'uuids' => ['required', 'array', 'min:1'],
            'uuids.*' => ['string'],
        ]);

        $modelClass = $request->model;

        if (! class_exists($modelClass)) {
            return $this->errorResponse('Model class not found.', 400);
        }

        $this->trashService->bulkRestore($modelClass, $request->uuids);

        return $this->successResponse(
            null,
            count($request->uuids).' record(s) restored successfully.'
        );
    }

    /**
     * Bulk permanently delete trashed records.
     *
     * Force delete multiple soft-deleted records by model class and UUIDs.
     *
     * @bodyParam model string required The fully qualified model class name. Example: App\Models\Employee
     * @bodyParam uuids string[] required Array of UUIDs of trashed records. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'uuids' => ['required', 'array', 'min:1'],
            'uuids.*' => ['string'],
        ]);

        $modelClass = $request->model;

        if (! class_exists($modelClass)) {
            return $this->errorResponse('Model class not found.', 400);
        }

        $this->trashService->bulkForceDelete($modelClass, $request->uuids);

        return $this->deletedResponse(
            count($request->uuids).' record(s) permanently deleted.'
        );
    }
}
