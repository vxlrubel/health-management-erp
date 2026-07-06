<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utility\StoreSystemConfigurationRequest;
use App\Http\Requests\Utility\UpdateSystemConfigurationRequest;
use App\Http\Resources\Utility\SystemConfigurationCollection;
use App\Http\Resources\Utility\SystemConfigurationResource;
use App\Models\SystemConfiguration;
use App\Services\ExportCenterService;
use App\Services\SystemConfigurationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SystemConfigurationController extends Controller
{
    public function __construct(
        protected SystemConfigurationService $configService,
        protected ExportCenterService $exportService,
    ) {}

    /**
     * List all system configurations.
     *
     * Retrieve a paginated list of system configurations. Supports filtering by
     * search term, group, and type.
     *
     * @queryParam search string Search by key or description. Example: app_name
     * @queryParam group string Filter by group. Example: general
     * @queryParam type string Filter by type. Example: text
     * @queryParam per_page int Items per page (default: 15). Example: 20
     * @queryParam sort_by string Sort field (default: created_at). Example: key
     * @queryParam sort_order string Sort order (default: desc). Example: asc
     */
    public function index(Request $request): JsonResponse
    {
        $configs = $this->configService->paginate(
            $request->only(['search', 'group', 'type']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new SystemConfigurationCollection($configs)
        );
    }

    /**
     * Store a new system configuration.
     *
     * Create a new system configuration with the provided key, value, type,
     * description, and group.
     *
     * @bodyParam key string required Unique configuration key. Example: app.name
     * @bodyParam value string required Configuration value. Example: HealthERP
     * @bodyParam type string required Must be one of text, boolean, number, json. Example: text
     * @bodyParam description string Description of the configuration. Example: Application name
     * @bodyParam group string Configuration group. Example: general
     */
    public function store(StoreSystemConfigurationRequest $request): JsonResponse
    {
        $config = $this->configService->create($request->validated());

        return $this->createdResponse(
            new SystemConfigurationResource($config),
            'Configuration created successfully.'
        );
    }

    /**
     * Show a system configuration.
     *
     * Display the details of a specific system configuration by UUID.
     */
    public function show(string $uuid): JsonResponse
    {
        $config = $this->configService->findByUuid($uuid);

        if (! $config) {
            return $this->notFoundResponse('Configuration not found.');
        }

        return $this->successResponse(
            new SystemConfigurationResource($config)
        );
    }

    /**
     * Update a system configuration.
     *
     * Update the specified system configuration. The key must be unique,
     * excluding the current record.
     *
     * @bodyParam key string required Configuration key. Example: app.name
     * @bodyParam value string required Configuration value. Example: HealthERP
     * @bodyParam type string required Must be one of text, boolean, number, json. Example: text
     * @bodyParam description string Description of the configuration. Example: Application name
     * @bodyParam group string Configuration group. Example: general
     */
    public function update(UpdateSystemConfigurationRequest $request, string $uuid): JsonResponse
    {
        $config = $this->configService->findByUuid($uuid);

        if (! $config) {
            return $this->notFoundResponse('Configuration not found.');
        }

        $config = $this->configService->update($config, $request->validated());

        return $this->successResponse(
            new SystemConfigurationResource($config),
            'Configuration updated successfully.'
        );
    }

    /**
     * Delete a system configuration (soft delete).
     *
     * Soft delete the specified system configuration. It can be restored later.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $config = $this->configService->findByUuid($uuid);

        if (! $config) {
            return $this->notFoundResponse('Configuration not found.');
        }

        $this->configService->delete($config);

        return $this->deletedResponse('Configuration deleted successfully.');
    }

    /**
     * List trashed system configurations.
     *
     * Retrieve all soft-deleted system configurations.
     */
    public function trash(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $configs = SystemConfiguration::onlyTrashed()->paginate($perPage);

        return $this->paginatedResponse(
            new SystemConfigurationCollection($configs)
        );
    }

    /**
     * Restore a trashed system configuration.
     *
     * Restore a previously soft-deleted system configuration by UUID.
     */
    public function restore(string $uuid): JsonResponse
    {
        $config = SystemConfiguration::withTrashed()->where('uuid', $uuid)->first();

        if (! $config) {
            return $this->notFoundResponse('Configuration not found.');
        }

        if (! $config->trashed()) {
            return $this->errorResponse('Configuration is not trashed.', 400);
        }

        $config->restore();

        return $this->successResponse(
            new SystemConfigurationResource($config),
            'Configuration restored successfully.'
        );
    }

    /**
     * Permanently delete a system configuration.
     *
     * Force delete a system configuration from the database permanently.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $config = SystemConfiguration::withTrashed()->where('uuid', $uuid)->first();

        if (! $config) {
            return $this->notFoundResponse('Configuration not found.');
        }

        $config->forceDelete();

        return $this->deletedResponse('Configuration permanently deleted.');
    }

    /**
     * Bulk delete system configurations.
     *
     * Soft delete multiple system configurations by providing an array of UUIDs.
     *
     * @bodyParam uuids string[] required Array of configuration UUIDs. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'uuids' => ['required', 'array', 'min:1'],
            'uuids.*' => ['string', 'exists:system_configurations,uuid'],
        ]);

        SystemConfiguration::whereIn('uuid', $request->uuids)->each(function ($config) {
            $config->delete();
        });

        return $this->deletedResponse(count($request->uuids).' configuration(s) deleted successfully.');
    }

    /**
     * Bulk restore system configurations.
     *
     * Restore multiple soft-deleted system configurations by UUID.
     *
     * @bodyParam uuids string[] required Array of configuration UUIDs. Example: ["uuid-1", "uuid-2"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate([
            'uuids' => ['required', 'array', 'min:1'],
            'uuids.*' => ['string'],
        ]);

        $count = 0;
        SystemConfiguration::withTrashed()
            ->whereIn('uuid', $request->uuids)
            ->each(function ($config) use (&$count) {
                if ($config->trashed()) {
                    $config->restore();
                    $count++;
                }
            });

        return $this->successResponse(null, "{$count} configuration(s) restored successfully.");
    }

    /**
     * Export system configurations.
     *
     * Export the system configurations list in the specified format (csv, excel, pdf).
     *
     * @urlParam format string required Export format: csv, excel, or pdf. Example: csv
     */
    public function export(Request $request, string $format): JsonResponse|StreamedResponse
    {
        $query = SystemConfiguration::query();

        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        $columns = [
            'uuid' => 'UUID',
            'key' => 'Key',
            'value' => 'Value',
            'type' => 'Type',
            'group' => 'Group',
            'created_at' => 'Created At',
        ];

        $filename = "system-configurations.{$format}";

        return match ($format) {
            'csv' => $this->exportService->exportCsv($query, $columns, $filename),
            'excel' => $this->exportService->exportExcel($query, $columns, $filename),
            'pdf' => $this->exportService->exportPdf('exports.system-configurations', [
                'configs' => $query->get(),
            ], $filename),
            default => $this->errorResponse('Unsupported export format.', 400),
        };
    }
}
