<?php

namespace App\Traits;

trait SyncsIsDeleteFlag
{
    protected static function bootSyncsIsDeleteFlag(): void
    {
        static::deleted(function ($model) {
            $model->newQueryWithoutScopes()
                ->whereKey($model->getKey())
                ->update(['is_delete' => true]);

            $model->is_delete = true; 
        });

        static::restored(function ($model) {
            $model->newQueryWithoutScopes()
                ->whereKey($model->getKey())
                ->update(['is_delete' => false]);

            $model->is_delete = false;
        });
    }
}