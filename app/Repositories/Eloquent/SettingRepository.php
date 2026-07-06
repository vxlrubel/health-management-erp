<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    protected function searchableFields(): array
    {
        return ['key', 'group', 'name', 'description'];
    }

    public function findByKey(string $key): ?Setting
    {
        return $this->query()->where('key', $key)->first();
    }

    public function getByGroup(string $group): Collection
    {
        return $this->query()->where('group', $group)->get();
    }

    public function getPublic(): Collection
    {
        return $this->query()->where('is_public', true)->get();
    }
}
