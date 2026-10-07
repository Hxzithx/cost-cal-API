<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionLog extends Model
{
    protected $fillable = [
        'dish_id',
        'dish_name',
        'produced_qty',
        'total_cost',
        'produced_at',
        'consumed_batches',
    ];

    protected $casts = [
        'produced_qty' => 'float',
        'total_cost' => 'float',
        'consumed_batches' => 'array',
    ];
}
