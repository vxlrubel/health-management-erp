<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    /**
     * Check application health.
     *
     * Returns the overall health status of the application, including database
     * connectivity, cache reachability, and application metadata.
     *
     * @responseField status string Overall health status (healthy/unhealthy).
     * @responseField timestamp string Current server timestamp.
     * @responseField services object Status of individual services (database, cache).
     */
    public function check(): JsonResponse
    {
        $services = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
        ];

        $overallStatus = collect($services)->every(fn ($s) => $s['healthy']) ? 'healthy' : 'unhealthy';

        $data = [
            'status' => $overallStatus,
            'timestamp' => now()->toIso8601String(),
            'services' => $services,
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
                'debug' => config('app.debug'),
                'url' => config('app.url'),
                'version' => '1.0.0',
            ],
        ];

        $httpStatus = $overallStatus === 'healthy' ? 200 : 503;

        return $this->successResponse($data, $httpStatus === 200 ? 'Application is healthy.' : 'Application is experiencing issues.', $httpStatus);
    }

    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();

            return [
                'healthy' => true,
                'message' => 'Database connection is active.',
                'connection' => config('database.default'),
            ];
        } catch (\Throwable $e) {
            return [
                'healthy' => false,
                'message' => 'Database connection failed: '.$e->getMessage(),
                'connection' => config('database.default'),
            ];
        }
    }

    private function checkCache(): array
    {
        try {
            $key = 'health_check_'.now()->timestamp;
            Cache::put($key, true, 10);
            $retrieved = Cache::get($key);
            Cache::forget($key);

            return [
                'healthy' => $retrieved === true,
                'message' => $retrieved === true ? 'Cache is reachable.' : 'Cache returned unexpected value.',
                'driver' => config('cache.default'),
            ];
        } catch (\Throwable $e) {
            return [
                'healthy' => false,
                'message' => 'Cache check failed: '.$e->getMessage(),
                'driver' => config('cache.default'),
            ];
        }
    }
}
