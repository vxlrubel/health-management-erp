<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftTemplate extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'branch_id', 'name',
        'start_time', 'end_time', 'planned_hours', 'break_minutes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'planned_hours' => 'decimal:2',
            'break_minutes' => 'integer',
            'status' => GeneralStatus::class,
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function recurringRotas(): HasMany
    {
        return $this->hasMany(RecurringRota::class);
    }
}
