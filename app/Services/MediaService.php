<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MediaService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Media::query();
        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        if (! empty($filters['model_type'])) {
            $query->where('model_type', $filters['model_type']);
        }

        if (! empty($filters['collection_name'])) {
            $query->where('collection_name', $filters['collection_name']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Media
    {
        return Media::find($id);
    }

    public function findByUuid(string $uuid): ?Media
    {
        return Media::where('uuid', $uuid)->first();
    }

    public function store(Model $model, UploadedFile $file, string $collection = 'default', array $customProperties = []): Media
    {
        $fileName = $file->getClientOriginalName();
        $path = $file->store("media/{$model->getTable()}/{$model->id}", 'public');

        return Media::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'collection_name' => $collection,
            'name' => pathinfo($fileName, PATHINFO_FILENAME),
            'file_name' => $fileName,
            'mime_type' => $file->getClientMimeType(),
            'disk' => 'public',
            'path' => $path,
            'size' => $file->getSize(),
            'custom_properties' => $customProperties,
        ]);
    }

    public function delete(Media $media): bool
    {
        $media->delete();

        return true;
    }

    public function forceDelete(string $uuid): bool
    {
        $media = Media::withTrashed()->where('uuid', $uuid)->first();
        if ($media) {
            $media->forceDelete();

            return true;
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        Media::whereIn('uuid', $uuids)->delete();

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        Media::withTrashed()->whereIn('uuid', $uuids)->restore();

        return true;
    }

    public function export(): Collection
    {
        return Media::all();
    }
}
