<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BulkActionsService
{
    protected array $supportedActions = ['delete', 'restore', 'force_delete', 'assign', 'status_change'];

    public function getSupportedActions(): array
    {
        return $this->supportedActions;
    }

    public function execute(string $action, string $modelClass, array $uuids, array $payload = []): array
    {
        if (! in_array($action, $this->supportedActions)) {
            return [
                'success' => false,
                'message' => "Unsupported action: {$action}.",
            ];
        }

        $methodName = 'process'.str_replace('_', '', ucwords($action, '_'));

        if (! method_exists($this, $methodName)) {
            return [
                'success' => false,
                'message' => "Action handler not found for: {$action}.",
            ];
        }

        return $this->$methodName($modelClass, $uuids, $payload);
    }

    protected function processDelete(string $modelClass, array $uuids, array $payload): array
    {
        $count = 0;
        $modelClass::whereIn('uuid', $uuids)->each(function (Model $model) use (&$count) {
            $model->delete();
            $count++;
        });

        return [
            'success' => true,
            'message' => "{$count} record(s) deleted successfully.",
            'count' => $count,
        ];
    }

    protected function processRestore(string $modelClass, array $uuids, array $payload): array
    {
        $count = 0;
        $modelClass::withTrashed()->whereIn('uuid', $uuids)->each(function (Model $model) use (&$count) {
            if ($model->trashed()) {
                $model->restore();
                $count++;
            }
        });

        return [
            'success' => true,
            'message' => "{$count} record(s) restored successfully.",
            'count' => $count,
        ];
    }

    protected function processForceDelete(string $modelClass, array $uuids, array $payload): array
    {
        $count = 0;
        $modelClass::withTrashed()->whereIn('uuid', $uuids)->each(function (Model $model) use (&$count) {
            $model->forceDelete();
            $count++;
        });

        return [
            'success' => true,
            'message' => "{$count} record(s) permanently deleted.",
            'count' => $count,
        ];
    }

    protected function processAssign(string $modelClass, array $uuids, array $payload): array
    {
        $field = $payload['field'] ?? 'assigned_to';
        $value = $payload['value'] ?? null;

        if (! $value) {
            return [
                'success' => false,
                'message' => 'Assignment value is required.',
            ];
        }

        $count = $modelClass::whereIn('uuid', $uuids)->update([$field => $value]);

        return [
            'success' => true,
            'message' => "{$count} record(s) assigned successfully.",
            'count' => $count,
        ];
    }

    protected function processStatusChange(string $modelClass, array $uuids, array $payload): array
    {
        $status = $payload['status'] ?? null;

        if (! $status) {
            return [
                'success' => false,
                'message' => 'Status value is required.',
            ];
        }

        $count = $modelClass::whereIn('uuid', $uuids)->update(['status' => $status]);

        return [
            'success' => true,
            'message' => "{$count} record(s) status updated to '{$status}'.",
            'count' => $count,
        ];
    }
}
