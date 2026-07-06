<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAudit
{
    protected static function bootHasAudit(): void
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive(static::class))) {
            static::deleting(function ($model) {
                if (Auth::check() && ! $model->isForceDeleting()) {
                    $model->deleted_by = Auth::id();
                    $model->save();
                }
            });

            static::restoring(function ($model) {
                $model->deleted_by = null;
            });
        }
    }
}
