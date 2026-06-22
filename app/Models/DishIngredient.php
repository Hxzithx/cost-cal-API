<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DishIngredient extends Pivot
{
    protected $fillable = [
        'dish_id',
        'ingrediant_id',
        'quantity',
        'unit',
        'default_wastage_quantity',
        'wastage_unit',
        'data',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'default_wastage_quantity' => 'decimal:4',
    ];
}
