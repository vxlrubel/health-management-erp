<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaCollection;
use App\Http\Resources\MediaResource;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService
    ) {}

    /**
     * List media
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'model_type', 'collection_name']);
        $options = [
            'per_page' => $request->input('per_page', 15),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_order' => $request->input('sort_order', 'desc'),
        ];

        $media = $this->mediaService->paginate($filters, $options);

        return $this->paginatedResponse(
            new MediaCollection($media)
        );
    }

    /**
     * Show media
     */
    public function show(int $id): JsonResponse
    {
        $media = $this->mediaService->findById($id);

        if (! $media) {
            return $this->notFoundResponse('Media not found.');
        }

        return $this->successResponse(
            new MediaResource($media)
        );
    }

    /**
     * Upload media
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'],
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'integer'],
            'collection_name' => ['nullable', 'string', 'max:255'],
        ]);

        $modelClass = $request->input('model_type');
        $model = $modelClass::findOrFail($request->input('model_id'));
        $collection = $request->input('collection_name', 'default');

        $media = $this->mediaService->store($model, $request->file('file'), $collection);

        return $this->createdResponse(
            new MediaResource($media),
            'Media uploaded successfully.'
        );
    }

    /**
     * Delete media
     */
    public function destroy(int $id): JsonResponse
    {
        $media = $this->mediaService->findById($id);

        if (! $media) {
            return $this->notFoundResponse('Media not found.');
        }

        $this->mediaService->delete($media);

        return $this->deletedResponse('Media deleted successfully.');
    }

    /**
     * Force delete media
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->mediaService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Media not found.');
        }

        return $this->deletedResponse('Media permanently deleted.');
    }

    /**
     * Bulk delete media
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->mediaService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Media deleted successfully.');
    }

    /**
     * Bulk restore media
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->mediaService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Media restored successfully.');
    }

    /**
     * Export media
     */
    public function export(): JsonResponse
    {
        $media = $this->mediaService->export();

        return $this->successResponse(
            MediaResource::collection($media),
            'Media exported successfully.'
        );
    }
}
