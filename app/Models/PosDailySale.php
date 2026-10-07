<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosDailySale extends Model
{
    protected $fillable = [
        'sale_date',
        'dish_id',
        'dish_name',
        'sold_qty',
        'unit_price',
        'total_revenue',
        'produced_qty_today',
        'variance_qty',
        'notes',
    ];

    protected $casts = [
        'sold_qty' => 'float',
        'unit_price' => 'float',
        'total_revenue' => 'float',
        'produced_qty_today' => 'float',
        'variance_qty' => 'float',
    ];
}
