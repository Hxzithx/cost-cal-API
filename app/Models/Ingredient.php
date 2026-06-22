<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'cost_price', 'purchase_unit_id', 'wastage_sell_price', 'wastage_sell_unit_id'])]
class Ingredient extends Model
{
    use HasFactory;

    /**
     * Get the purchase unit of this ingredient.
     */
    public function purchaseUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
    }

    /**
     * Get the wastage sell unit of this ingredient.
     */
    public function wastageSellUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'wastage_sell_unit_id');
    }

    /**
     * Get the dishes that use this ingredient.
     */
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class, 'dish_ingredient')
            ->using(DishIngredient::class)
            ->withPivot(['quantity', 'unit_id', 'wastage_quantity', 'wastage_unit_id'])
            ->withTimestamps();
    }
}
