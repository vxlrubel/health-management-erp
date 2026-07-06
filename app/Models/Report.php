<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid', 'name', 'type', 'filters_json', 'generated_by', 'file_path', 'status',
    ];

    protected function casts(): array
    {
        return [
            'filters_json' => 'array',
        ];
    }
}
