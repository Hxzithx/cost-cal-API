<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class Ingredient extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $table = 'ingredients';

    protected $fillable = [
        'name',
        'description',
        'external_id',
        'category_id',
        'stock_qty',
        'stock_unit_id',
        'min_level_qty',
        'wastage_per_unit',
        'cost_per_unit',
        'cost_unit_id',
        'supplier_id',
        'is_active',
        'data',
        'is_delete',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
        'stock_qty' => 'decimal:4',
        'min_level_qty' => 'decimal:4',
        'wastage_per_unit' => 'decimal:4',
        'cost_per_unit' => 'decimal:4',
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

    public static function buildData($ingredient): array
    {
        return [
            'name' => $ingredient->name,
            'description' => $ingredient->description,
            'external_id' => $ingredient->external_id,
            'category_id' => $ingredient->category_id,
            'stock_qty' => $ingredient->stock_qty,
            'stock_unit_id' => $ingredient->stock_unit_id,
            'min_level_qty' => $ingredient->min_level_qty,
            'wastage_per_unit' => $ingredient->wastage_per_unit,
            'cost_per_unit' => $ingredient->cost_per_unit,
            'cost_unit_id' => $ingredient->cost_unit_id,
            'supplier_id' => $ingredient->supplier_id,
            'is_active' => $ingredient->is_active,
        ];
    }

    public function dishIngredients()
    {
        return $this->hasMany(DishIngredient::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
