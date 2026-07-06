<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'model_type', 'model_id', 'collection_name',
        'name', 'file_name', 'mime_type', 'disk', 'path', 'size',
        'custom_properties',
    ];

    protected function casts(): array
    {
        return [
            'custom_properties' => 'array',
            'size' => 'integer',
        ];
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getFullPathAttribute(): string
    {
        return Storage::disk($this->disk)->path($this->path);
    }
}
