<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchCollection;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct(
        protected BranchService $branchService
    ) {}

    /**
     * List Branches
     *
     * Get a paginated list of branches.
     *
     * @queryParam page int Page number. Example: 1
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam search string Search term for name, code or city. Example: London
     * @queryParam status string Filter by status. Example: active
     */
    public function index(Request $request): JsonResponse
    {
        $branches = $this->branchService->paginate(
            $request->only(['search', 'status']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(new BranchCollection($branches));
    }

    /**
     * Create Branch
     *
     * Store a newly created branch.
     */
    public function store(StoreBranchRequest $request): JsonResponse
    {
        $branch = $this->branchService->create($request->validated());

        return $this->createdResponse(new BranchResource($branch), 'Branch created successfully.');
    }

    /**
     * Show Branch
     *
     * Display the specified branch by UUID.
     */
    public function show(string $uuid): JsonResponse
    {
        $branch = $this->branchService->findByUuid($uuid);

        if (! $branch) {
            return $this->notFoundResponse('Branch not found.');
        }

        return $this->successResponse(new BranchResource($branch), 'Branch retrieved successfully.');
    }

    /**
     * Update Branch
     *
     * Update the specified branch by UUID.
     */
    public function update(UpdateBranchRequest $request, string $uuid): JsonResponse
    {
        $branch = $this->branchService->findByUuid($uuid);

        if (! $branch) {
            return $this->notFoundResponse('Branch not found.');
        }

        $branch = $this->branchService->update($branch, $request->validated());

        return $this->successResponse(new BranchResource($branch), 'Branch updated successfully.');
    }

    /**
     * Delete Branch
     *
     * Soft delete the specified branch by UUID.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $branch = $this->branchService->findByUuid($uuid);

        if (! $branch) {
            return $this->notFoundResponse('Branch not found.');
        }

        $this->branchService->softDelete($branch);

        return $this->deletedResponse('Branch deleted successfully.');
    }

    /**
     * Trashed Branches
     *
     * Get a paginated list of soft-deleted branches.
     *
     * @queryParam page int Page number. Example: 1
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam search string Search term for name, code or city. Example: London
     */
    public function trash(Request $request): JsonResponse
    {
        $branches = $this->branchService->trash(
            $request->only(['search']),
            $request->only(['per_page'])
        );

        return $this->paginatedResponse(new BranchCollection($branches));
    }

    /**
     * Restore Branch
     *
     * Restore the specified soft-deleted branch by UUID.
     */
    public function restore(string $uuid): JsonResponse
    {
        $branch = $this->branchService->restore($uuid);

        if (! $branch) {
            return $this->notFoundResponse('Branch not found or already restored.');
        }

        return $this->successResponse(new BranchResource($branch), 'Branch restored successfully.');
    }

    /**
     * Force Delete Branch
     *
     * Permanently delete the specified branch by UUID.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->branchService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Branch not found.');
        }

        return $this->deletedResponse('Branch permanently deleted.');
    }

    /**
     * Bulk Delete Branches
     *
     * Soft delete multiple branches by UUIDs.
     *
     * @bodyParam uuids array required Array of branch UUIDs to delete. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'uuids' => ['required', 'array'],
            'uuids.*' => ['required', 'string'],
        ]);

        $this->branchService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Branches deleted successfully.');
    }

    /**
     * Bulk Restore Branches
     *
     * Restore multiple soft-deleted branches by UUIDs.
     *
     * @bodyParam uuids array required Array of branch UUIDs to restore. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate([
            'uuids' => ['required', 'array'],
            'uuids.*' => ['required', 'string'],
        ]);

        $this->branchService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Branches restored successfully.');
    }

    /**
     * Export Branches
     *
     * Export branches data based on filters.
     *
     * @queryParam status string Filter by status. Example: active
     * @queryParam city string Filter by city. Example: London
     */
    public function export(Request $request): JsonResponse
    {
        $branches = $this->branchService->export($request->only(['status', 'city']));

        return $this->successResponse(BranchResource::collection($branches), 'Branches exported successfully.');
    }
}
