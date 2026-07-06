<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreFormRequest;
use App\Http\Requests\Finance\UpdateFormRequest;
use App\Http\Resources\Finance\FormCollection;
use App\Http\Resources\Finance\FormResource;
use App\Services\Finance\FormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct(
        protected FormService $service,
    ) {}

    /**
     * List forms
     *
     * @queryParam search string Search term. Example: "Feedback"
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam page int Page number. Example: 1
     * @queryParam status string Filter by status. Example: published
     */
    public function index(Request $request): FormCollection
    {
        $forms = $this->service->paginate($request->all(), $request->all());

        return new FormCollection($forms);
    }

    /**
     * Show form
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $form = $this->service->findByUuid($uuid);

        if (! $form) {
            return $this->notFoundResponse('Form not found.');
        }

        return $this->successResponse(new FormResource($form));
    }

    /**
     * Create form
     *
     * @bodyParam name string required Form name. Example: "Employee Feedback"
     * @bodyParam description string Form description. Example: "Monthly feedback form"
     * @bodyParam schema_json object required JSON schema. Example: {"fields":[]}
     * @bodyParam branch_id int Branch ID. Example: 1
     */
    public function store(StoreFormRequest $request): JsonResponse
    {
        $form = $this->service->create($request->validated());

        return $this->createdResponse(new FormResource($form), 'Form created successfully.');
    }

    /**
     * Update form
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam name string Form name. Example: "Updated Form"
     */
    public function update(UpdateFormRequest $request, string $uuid): JsonResponse
    {
        $form = $this->service->findByUuid($uuid);

        if (! $form) {
            return $this->notFoundResponse('Form not found.');
        }

        $form = $this->service->update($form, $request->validated());

        return $this->successResponse(new FormResource($form), 'Form updated successfully.');
    }

    /**
     * Delete form (soft)
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $form = $this->service->findByUuid($uuid);

        if (! $form) {
            return $this->notFoundResponse('Form not found.');
        }

        $this->service->softDelete($form);

        return $this->deletedResponse('Form deleted successfully.');
    }

    /**
     * Publish form
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function publish(string $uuid): JsonResponse
    {
        $form = $this->service->publish($uuid);

        if (! $form) {
            return $this->notFoundResponse('Form not found.');
        }

        return $this->successResponse(new FormResource($form), 'Form published successfully.');
    }

    /**
     * Archive form
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function archive(string $uuid): JsonResponse
    {
        $form = $this->service->archive($uuid);

        if (! $form) {
            return $this->notFoundResponse('Form not found.');
        }

        return $this->successResponse(new FormResource($form), 'Form archived successfully.');
    }

    /**
     * Assign form to subject
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam subject_type string required Subject model class. Example: App\Models\Employee
     * @bodyParam subject_id int required Subject ID. Example: 1
     * @bodyParam answers_json object Answers JSON. Example: {}
     */
    public function assign(Request $request, string $uuid): JsonResponse
    {
        $request->validate([
            'subject_type' => ['required', 'string'],
            'subject_id' => ['required', 'integer'],
            'answers_json' => ['nullable', 'json'],
            'status' => ['nullable', 'string'],
        ]);

        $submission = $this->service->assign($uuid, $request->all());

        if (! $submission) {
            return $this->notFoundResponse('Form not found.');
        }

        return $this->createdResponse($submission, 'Form assigned successfully.');
    }

    /**
     * List trashed forms
     *
     * @queryParam per_page int Items per page. Example: 15
     */
    public function trash(Request $request): FormCollection
    {
        $forms = $this->service->paginate(
            array_merge($request->all(), ['trashed' => true]),
            $request->all()
        );

        return new FormCollection($forms);
    }

    /**
     * Restore form
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $form = $this->service->restore($uuid);

        if (! $form) {
            return $this->notFoundResponse('Form not found in trash.');
        }

        return $this->successResponse(new FormResource($form), 'Form restored successfully.');
    }

    /**
     * Force delete form
     *
     * @urlParam uuid string required Form UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->service->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Form not found.');
        }

        return $this->deletedResponse('Form permanently deleted.');
    }

    /**
     * Bulk delete forms
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Forms deleted successfully.');
    }

    /**
     * Bulk restore forms
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Forms restored successfully.');
    }
}
