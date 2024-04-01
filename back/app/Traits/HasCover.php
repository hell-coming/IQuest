<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Storage;


trait HasCover
{
    protected static function bootHasCover(): void
    {
        static::updated(function (Model $model) {
            if ($model->isDirty('cover')) {
                Storage::delete('public/' . $model->getOriginal('cover'));
            }
        });

        static::deleted(function (Model $model) {
            Storage::delete('public/' . $model->cover);
        });
    }
}
