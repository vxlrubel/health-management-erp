<?php

namespace App\Models;

use App\Enums\FormStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'branch_id', 'name', 'description',
        'schema_json', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'schema_json' => 'json',
            'status' => FormStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class, 'form_id');
    }

    public function publish(): void
    {
        $this->update([
            'status' => FormStatus::Published,
            'published_at' => now(),
        ]);
    }

    public function archive(): void
    {
        $this->update([
            'status' => FormStatus::Archived,
            'published_at' => null,
        ]);
    }
}
