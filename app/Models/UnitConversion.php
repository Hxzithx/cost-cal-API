<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class UnitConversion extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $table = 'unit_conversation';

    protected $fillable = [
        'parent_unit_id',
        'child_unit_id',
        'factor',
        'data',
        'is_delete',
    ];

    protected $casts = [
        'factor' => 'decimal:4',
        'data' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($unitConversion) {
            $unitConversion->data = self::buildData($unitConversion);
        });

        static::updating(function ($unitConversion) {
            $unitConversion->data = self::buildData($unitConversion);
        });
    }

    private static function buildData($unitConversion): array
    {
        return [
            'parent_unit_id' => $unitConversion->parent_unit_id,
            'child_unit_id'  => $unitConversion->child_unit_id,
            'factor'         => $unitConversion->factor,
        ];
    }

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
