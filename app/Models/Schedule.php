<?php

namespace App\Models;

use App\Enums\ScheduleStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'rota_id', 'employee_id', 'client_id', 'branch_id',
        'start_datetime', 'end_datetime', 'planned_hours',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_datetime' => 'datetime',
            'end_datetime' => 'datetime',
            'planned_hours' => 'decimal:2',
            'status' => ScheduleStatus::class,
        ];
    }

    public function rota(): BelongsTo
    {
        return $this->belongsTo(Rota::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
