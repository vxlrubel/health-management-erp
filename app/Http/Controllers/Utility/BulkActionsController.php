<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Services\BulkActionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BulkActionsController extends Controller
{
    public function __construct(
        protected BulkActionsService $bulkActionsService,
    ) {}

    /**
     * List supported bulk actions.
     *
     * Returns a list of all available bulk actions (delete, restore, force_delete,
     * assign, status_change).
     */
    public function index(): JsonResponse
    {
        return $this->successResponse([
            'actions' => $this->bulkActionsService->getSupportedActions(),
        ]);
    }

    /**
     * Execute a bulk action.
     *
     * Execute a bulk action on multiple records. The supported actions are:
     * delete, restore, force_delete, assign, status_change.
     *
     * @bodyParam action string required The action to execute. Example: delete
     * @bodyParam model string required The fully qualified model class name. Example: App\Models\Employee
     * @bodyParam uuids string[] required Array of record UUIDs. Example: ["uuid-1", "uuid-2"]
     * @bodyParam payload object Optional payload for the action (e.g., status, assignee).
     *
     * @responseField success boolean Whether the action was successful.
     * @responseField message string Result message.
     * @responseField count int|null Number of affected records.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'action' => ['required', 'string', 'in:'.implode(',', $this->bulkActionsService->getSupportedActions())],
            'model' => ['required', 'string'],
            'uuids' => ['required', 'array', 'min:1'],
            'uuids.*' => ['string'],
            'payload' => ['nullable', 'array'],
        ]);

        $modelClass = $request->model;

        if (! class_exists($modelClass)) {
            return $this->errorResponse('Model class not found.', 400);
        }

        $result = $this->bulkActionsService->execute(
            $request->action,
            $modelClass,
            $request->uuids,
            $request->payload ?? []
        );

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 400);
        }

        return $this->successResponse(
            ['count' => $result['count'] ?? null],
            $result['message']
        );
    }
}
