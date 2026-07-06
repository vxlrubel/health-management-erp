<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingCollection;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    /**
     * List settings
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'group']);
        $options = [
            'per_page' => $request->input('per_page', 15),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_order' => $request->input('sort_order', 'desc'),
        ];

        $settings = $this->settingService->paginate($filters, $options);

        return $this->paginatedResponse(
            new SettingCollection($settings)
        );
    }

    /**
     * Show setting
     */
    public function show(Setting $setting): JsonResponse
    {
        return $this->successResponse(
            new SettingResource($setting)
        );
    }

    /**
     * Create setting
     */
    public function store(StoreSettingRequest $request): JsonResponse
    {
        $setting = $this->settingService->create($request->validated());

        return $this->createdResponse(
            new SettingResource($setting),
            'Setting created successfully.'
        );
    }

    /**
     * Update setting
     */
    public function update(UpdateSettingRequest $request, Setting $setting): JsonResponse
    {
        $setting = $this->settingService->update($setting, $request->validated());

        return $this->successResponse(
            new SettingResource($setting),
            'Setting updated successfully.'
        );
    }

    /**
     * Delete setting
     */
    public function destroy(Setting $setting): JsonResponse
    {
        $this->settingService->delete($setting);

        return $this->deletedResponse('Setting deleted successfully.');
    }

    /**
     * Get settings by group
     */
    public function byGroup(string $group): JsonResponse
    {
        $settings = $this->settingService->getByGroup($group);

        return $this->successResponse(
            SettingResource::collection($settings)
        );
    }

    /**
     * Get public settings
     */
    public function public(): JsonResponse
    {
        $settings = $this->settingService->getPublic();

        return $this->successResponse(
            SettingResource::collection($settings)
        );
    }

    /**
     * Export settings
     */
    public function export(): JsonResponse
    {
        $settings = $this->settingService->export();

        return $this->successResponse(
            SettingResource::collection($settings),
            'Settings exported successfully.'
        );
    }
}
