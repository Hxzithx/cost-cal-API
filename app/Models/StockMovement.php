<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'movement_type',
        'reference_no',
        'source_location_id',
        'source_location_name',
        'destination_location_id',
        'destination_location_name',
        'ingredient_id',
        'ingredient_name',
        'batch_no',
        'qty',
        'unit_id',
        'unit_symbol',
        'unit_cost',
        'total_cost',
        'movement_date',
        'reason',
        'notes',
        'status',
    ];

    protected $casts = [
        'qty' => 'float',
        'unit_cost' => 'float',
        'total_cost' => 'float',
    ];
}
