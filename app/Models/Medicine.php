<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'client_id', 'name', 'dosage', 'frequency', 'route',
        'start_date', 'end_date', 'prescribed_by', 'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => GeneralStatus::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function administrations(): HasMany
    {
        return $this->hasMany(MedicineAdministration::class);
    }
}
