<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'description'])]
class Dish extends Model
{
    use HasFactory;

    /**
     * Get the ingredients used in this dish.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'dish_ingredient')
            ->using(DishIngredient::class)
            ->withPivot(['quantity', 'unit_id', 'wastage_quantity', 'wastage_unit_id'])
            ->withTimestamps();
    }
}
