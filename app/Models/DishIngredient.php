<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishIngredient extends Model
{
    use SoftDeletes;

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
    ];

    protected $casts = [
        'default_recipe_qty' => 'decimal:4',
        'default_cost_per_unit' => 'decimal:4',
        'default_wastage_qty' => 'decimal:4',
        'default_wastage_sell_price' => 'decimal:4',
        'data' => 'array',
    ];

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