<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Registered searchable modules.
     */
    protected array $modules = [];

    public function registerModule(string $label, string $modelClass, array $searchableColumns, ?callable $formatter = null): void
    {
        $this->modules[$label] = [
            'model' => $modelClass,
            'columns' => $searchableColumns,
            'formatter' => $formatter,
        ];
    }

    public function getModules(): array
    {
        return $this->modules;
    }

    public function search(string $query, ?array $moduleNames = null): Collection
    {
        $results = collect();
        $modules = $moduleNames
            ? array_intersect_key($this->modules, array_flip($moduleNames))
            : $this->modules;

        if (empty($query) || strlen(trim($query)) < 2) {
            return $results;
        }

        $searchTerm = trim($query);

        foreach ($modules as $label => $config) {
            $modelClass = $config['model'];
            $queryBuilder = $modelClass::query();

            $queryBuilder->where(function ($q) use ($searchTerm, $config) {
                foreach ($config['columns'] as $column) {
                    $q->orWhere($column, 'like', "%{$searchTerm}%");
                }
            });

            $queryBuilder->limit(20);

            $formatter = $config['formatter'] ?? null;

            foreach ($queryBuilder->get() as $item) {
                if ($formatter) {
                    $results->push($formatter($item, $label));
                } else {
                    $results->push([
                        'uuid' => $item->uuid ?? $item->id,
                        'module' => $label,
                        'model_class' => get_class($item),
                        'title' => (string) $item,
                        'url' => null,
                    ]);
                }
            }
        }

        return $results;
    }
}
