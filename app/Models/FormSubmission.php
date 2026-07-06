<?php

namespace App\Models;

use App\Traits\HasAudit;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSubmission extends Model
{
    use HasAudit, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'form_id', 'submitted_by', 'subject_type',
        'subject_id', 'answers_json', 'status', 'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'answers_json' => 'json',
            'submitted_at' => 'datetime',
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
