<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ratesheet extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'branch_id', 'name', 'description',
        'hourly_rate', 'weekend_rate', 'holiday_rate', 'night_rate',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
            'weekend_rate' => 'decimal:2',
            'holiday_rate' => 'decimal:2',
            'night_rate' => 'decimal:2',
            'status' => GeneralStatus::class,
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function rotas(): HasMany
    {
        return $this->hasMany(Rota::class);
    }
}
