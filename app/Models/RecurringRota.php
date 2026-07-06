<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurringRota extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'branch_id', 'rota_id', 'shift_template_id',
        'frequency', 'days_of_week', 'start_date', 'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'days_of_week' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => GeneralStatus::class,
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function rota(): BelongsTo
    {
        return $this->belongsTo(Rota::class);
    }

    public function shiftTemplate(): BelongsTo
    {
        return $this->belongsTo(ShiftTemplate::class);
    }
}
