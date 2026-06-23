<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitConversion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_unit_id',
        'child_unit_id',
        'factor',
        'data',
    ];

    protected $casts = [
        'factor' => 'decimal:4',
        'data' => 'array',
    ];

    protected $appends = ['representation'];

    public function parentUnit()
    {
        return $this->belongsTo(Unit::class, 'parent_unit_id');
    }

    public function childUnit()
    {
        return $this->belongsTo(Unit::class, 'child_unit_id');
    }

    public function getRepresentationAttribute(): string
    {
        return "1 {$this->parentUnit->symbol} = {$this->factor} {$this->childUnit->symbol}";
    }
}
