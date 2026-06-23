<?php

namespace App\Traits;

trait SyncsIsDeleteFlag
{
    protected static function bootSyncsIsDeleteFlag(): void
    {
        static::deleting(function ($model) {
            $model->is_delete = true;
        });

        static::restoring(function ($model) {
            $model->is_delete = false;
        });
    }
}