<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeDocument\StoreEmployeeDocumentRequest;
use App\Http\Requests\EmployeeDocument\UpdateEmployeeDocumentRequest;
use App\Http\Resources\EmployeeDocumentCollection;
use App\Http\Resources\EmployeeDocumentResource;
use App\Models\EmployeeDocument;
use App\Services\EmployeeDocumentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeDocumentController extends Controller
{
    protected EmployeeDocumentService $documentService;

    public function __construct(EmployeeDocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Display a paginated listing of employee documents.
     */
    public function index(Request $request): JsonResponse
    {
        $documents = $this->documentService->paginate(
            $request->only(['employee_id', 'type', 'is_verified']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(new EmployeeDocumentCollection($documents));
    }

    /**
     * Display the specified employee document.
     */
    public function show(string $uuid): JsonResponse
    {
        $document = $this->documentService->findByUuid($uuid);

        if (! $document) {
            return $this->notFoundResponse('Employee document not found.');
        }

        return $this->successResponse(new EmployeeDocumentResource($document));
    }

    /**
     * Store a newly created employee document.
     */
    public function store(StoreEmployeeDocumentRequest $request): JsonResponse
    {
        $document = $this->documentService->create($request->validated());

        return $this->createdResponse(new EmployeeDocumentResource($document), 'Employee document created successfully.');
    }

    /**
     * Update the specified employee document.
     */
    public function update(UpdateEmployeeDocumentRequest $request, EmployeeDocument $employeeDocument): JsonResponse
    {
        $document = $this->documentService->update($employeeDocument, $request->validated());

        return $this->successResponse(new EmployeeDocumentResource($document), 'Employee document updated successfully.');
    }

    /**
     * Remove the specified employee document (soft delete).
     */
    public function destroy(EmployeeDocument $employeeDocument): JsonResponse
    {
        $this->documentService->delete($employeeDocument);

        return $this->deletedResponse('Employee document deleted successfully.');
    }

    /**
     * Display a paginated listing of trashed employee documents.
     */
    public function trash(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $documents = EmployeeDocument::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse(new EmployeeDocumentCollection($documents));
    }

    /**
     * Restore a trashed employee document.
     */
    public function restore(string $uuid): JsonResponse
    {
        $document = $this->documentService->restore($uuid);

        if (! $document) {
            return $this->notFoundResponse('Employee document not found or not trashed.');
        }

        return $this->successResponse(new EmployeeDocumentResource($document), 'Employee document restored successfully.');
    }

    /**
     * Permanently delete a trashed employee document.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->documentService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Employee document not found.');
        }

        return $this->deletedResponse('Employee document permanently deleted.');
    }

    /**
     * Bulk delete employee documents.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'exists:employee_documents,uuid']]);

        $this->documentService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Employee documents deleted successfully.');
    }

    /**
     * Bulk restore employee documents.
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->documentService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Employee documents restored successfully.');
    }

    /**
     * Export employee documents list.
     */
    public function export(Request $request): JsonResponse
    {
        return $this->successResponse(null, 'Export functionality not implemented yet.');
    }
}
