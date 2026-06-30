<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class DishIngredient extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $table = 'dish_ingredient';

    protected $fillable = [
        'dish_id',
        'ingredient_id',
        'default_recipe_qty',
        'unit_id',
        'default_cost_per_unit',
        'cost_unit_id',
        'default_wastage_qty',
        'wastage_unit_id',
        'default_wastage_sell_price',
        'data',
        'is_delete',
    ];

    protected $casts = [
        'default_recipe_qty' => 'decimal:4',
        'default_cost_per_unit' => 'decimal:4',
        'default_wastage_qty' => 'decimal:4',
        'default_wastage_sell_price' => 'decimal:4',
        'data' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($dishIngredient) {
            $dishIngredient->data = self::buildData($dishIngredient);
        });

        static::updating(function ($dishIngredient) {
            $dishIngredient->data = self::buildData($dishIngredient);
        });
    }

    public static function buildData($dishIngredient): array
    {
        return [
            'dish_id'                    => $dishIngredient->dish_id,
            'ingredient_id'              => $dishIngredient->ingredient_id,
            'default_recipe_qty'         => $dishIngredient->default_recipe_qty,
            'unit_id'                    => $dishIngredient->unit_id,
            'default_cost_per_unit'      => $dishIngredient->default_cost_per_unit,
            'cost_unit_id'               => $dishIngredient->cost_unit_id,
            'default_wastage_qty'        => $dishIngredient->default_wastage_qty,
            'wastage_unit_id'            => $dishIngredient->wastage_unit_id,
            'default_wastage_sell_price' => $dishIngredient->default_wastage_sell_price,
        ];
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function costUnit()
    {
        return $this->belongsTo(Unit::class, 'cost_unit_id');
    }

    public function wastageUnit()
    {
        return $this->belongsTo(Unit::class, 'wastage_unit_id');
    }
}