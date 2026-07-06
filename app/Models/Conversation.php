<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasUuid;

    protected $fillable = ['uuid', 'subject'];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
