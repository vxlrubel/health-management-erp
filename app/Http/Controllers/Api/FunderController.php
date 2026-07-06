<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Funder\StoreFunderRequest;
use App\Http\Requests\Funder\UpdateFunderRequest;
use App\Http\Resources\FunderCollection;
use App\Http\Resources\FunderResource;
use App\Models\Funder;
use App\Services\FunderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FunderController extends Controller
{
    protected FunderService $funderService;

    public function __construct(FunderService $funderService)
    {
        $this->funderService = $funderService;
    }

    /**
     * Display a paginated listing of funders.
     */
    public function index(Request $request): JsonResponse
    {
        $funders = $this->funderService->paginate(
            $request->only(['search', 'status']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(new FunderCollection($funders));
    }

    /**
     * Display the specified funder.
     */
    public function show(string $uuid): JsonResponse
    {
        $funder = $this->funderService->findByUuid($uuid);

        if (! $funder) {
            return $this->notFoundResponse('Funder not found.');
        }

        return $this->successResponse(new FunderResource($funder));
    }

    /**
     * Store a newly created funder.
     */
    public function store(StoreFunderRequest $request): JsonResponse
    {
        $funder = $this->funderService->create($request->validated());

        return $this->createdResponse(new FunderResource($funder), 'Funder created successfully.');
    }

    /**
     * Update the specified funder.
     */
    public function update(UpdateFunderRequest $request, Funder $funder): JsonResponse
    {
        $funder = $this->funderService->update($funder, $request->validated());

        return $this->successResponse(new FunderResource($funder), 'Funder updated successfully.');
    }

    /**
     * Remove the specified funder (soft delete).
     */
    public function destroy(Funder $funder): JsonResponse
    {
        $this->funderService->delete($funder);

        return $this->deletedResponse('Funder deleted successfully.');
    }

    /**
     * Display a paginated listing of trashed funders.
     */
    public function trash(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $funders = Funder::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse(new FunderCollection($funders));
    }

    /**
     * Restore a trashed funder.
     */
    public function restore(string $uuid): JsonResponse
    {
        $funder = $this->funderService->restore($uuid);

        if (! $funder) {
            return $this->notFoundResponse('Funder not found or not trashed.');
        }

        return $this->successResponse(new FunderResource($funder), 'Funder restored successfully.');
    }

    /**
     * Permanently delete a trashed funder.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->funderService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Funder not found.');
        }

        return $this->deletedResponse('Funder permanently deleted.');
    }

    /**
     * Bulk delete funders.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'exists:funders,uuid']]);

        $this->funderService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Funders deleted successfully.');
    }

    /**
     * Bulk restore funders.
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->funderService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Funders restored successfully.');
    }

    /**
     * Export funders list.
     */
    public function export(Request $request): JsonResponse
    {
        return $this->successResponse(null, 'Export functionality not implemented yet.');
    }
}
