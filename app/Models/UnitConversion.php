<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class UnitConversion extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $table = 'unit_conversions';

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

    protected $appends = ['representation'];

    protected static function booted(): void
    {
        static::creating(function ($conversion) {
            $conversion->data = self::buildData($conversion);
        });

        static::updating(function ($conversion) {
            $conversion->data = self::buildData($conversion);
        });
    }

    private static function buildData($conversion): array
    {
        return [
            'parent_unit_id' => $conversion->parent_unit_id,
            'child_unit_id' => $conversion->child_unit_id,
            'factor' => $conversion->factor,
        ];
    }

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