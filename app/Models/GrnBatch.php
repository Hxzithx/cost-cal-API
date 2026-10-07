<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrnBatch extends Model
{
    protected $fillable = [
        'master_ingredient_id',
        'grn_number',
        'batch_number',
        'supplier_id',
        'supplier_name',
        'received_date',
        'expiry_date',
        'initial_qty',
        'remaining_qty',
        'unit_id',
        'unit_cost',
        'location_id',
        'location_name',
    ];

    protected $casts = [
        'initial_qty' => 'float',
        'remaining_qty' => 'float',
        'unit_cost' => 'float',
    ];
}
