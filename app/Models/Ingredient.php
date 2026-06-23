<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;

    protected $table = "ingredients";
    protected $fillable = [
        'name',
        'external_id',
        'is_active',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
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
            'name'        => $ingredient->name,
            'external_id' => $ingredient->external_id,
            'is_active'   => $ingredient->is_active,
        ];
    }

    public function dishIngredients()
    {
        return $this->hasMany(DishIngredient::class);
    }

    // Handy when syncing from the external system — avoids creating duplicates
    public static function findOrCreateFromExternal(string $externalId, string $name): self
    {
        return self::firstOrCreate(
            ['external_id' => $externalId],
            ['name' => $name, 'is_active' => true]
        );
    }
}