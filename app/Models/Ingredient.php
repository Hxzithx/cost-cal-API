<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class Ingredient extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $fillable = [
        'name',
        'external_id',
        'is_active',
        'data',
        'is_delete',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($ingredient) {
            $ingredient->data = self::buildData($ingredient);
        });

        static::updating(function ($ingredient) {
            $ingredient->data = self::buildData($ingredient);
        });
    }

    private static function buildData($ingredient): array
    {
        return [
            'name' => $ingredient->name,
            'external_id' => $ingredient->external_id,
            'is_active' => $ingredient->is_active,
        ];
    }

    public function dishIngredients()
    {
        return $this->hasMany(DishIngredient::class);
    }
}