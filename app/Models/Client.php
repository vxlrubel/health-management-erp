<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasAudit, HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'funder_id',
        'client_no',
        'first_name',
        'last_name',
        'dob',
        'email',
        'phone',
        'address',
        'care_level',
        'status',
        'next_of_kin_name',
        'next_of_kin_phone',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'status' => GeneralStatus::class,
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function funder(): BelongsTo
    {
        return $this->belongsTo(Funder::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'client_employee')
            ->withPivot(['assigned_from', 'assigned_to', 'is_primary'])
            ->withTimestamps();
    }

    public function carePlans(): HasMany
    {
        return $this->hasMany(CarePlan::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class);
    }
}
