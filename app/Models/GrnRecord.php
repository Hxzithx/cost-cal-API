<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrnRecord extends Model
{
    protected $fillable = [
        'grn_no',
        'po_no',
        'ref_no',
        'is_consignment',
        'grn_date',
        'supplier_id',
        'supplier_name',
        'cost_centre',
        'po_status',
        'payment_term',
        'location_id',
        'location_name',
        'line_items',
        'financials',
        'status',
    ];

    protected $casts = [
        'is_consignment' => 'boolean',
        'line_items' => 'array',
        'financials' => 'array',
    ];
}
