<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        protected SearchService $searchService,
    ) {}

    /**
     * Global search across modules.
     *
     * Perform a cross-module search. The query parameter must be at least
     * 2 characters long. Optionally filter by specific modules.
     *
     * @queryParam q string required The search query. Example: John
     * @queryParam modules string[] Optional list of modules to search in. Example: ["employees", "clients"]
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:255'],
            'modules' => ['nullable', 'array'],
            'modules.*' => ['string'],
        ]);

        $results = $this->searchService->search(
            $request->q,
            $request->modules
        );

        return $this->successResponse([
            'data' => $results->values(),
            'total' => $results->count(),
            'query' => $request->q,
        ]);
    }

    /**
     * List available search modules.
     *
     * Returns all registered searchable modules and their labels.
     */
    public function modules(): JsonResponse
    {
        $modules = collect($this->searchService->getModules())
            ->map(fn ($config, $label) => [
                'label' => $label,
                'model' => $config['model'],
            ])
            ->values();

        return $this->successResponse([
            'data' => $modules,
        ]);
    }
}
