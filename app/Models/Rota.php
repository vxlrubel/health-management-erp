<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rota extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'branch_id', 'ratesheet_id', 'name',
        'start_date', 'end_date', 'start_time', 'end_time',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'string',
            'end_time' => 'string',
            'status' => GeneralStatus::class,
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function ratesheet(): BelongsTo
    {
        return $this->belongsTo(Ratesheet::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function recurringRotas(): HasMany
    {
        return $this->hasMany(RecurringRota::class);
    }
}
