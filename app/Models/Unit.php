<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $table = 'units';

    protected $fillable = [
        'name',
        'symbol',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($unit) {
            $unit->data = self::buildData($unit);
        });

        static::updating(function ($unit) {
            $unit->data = self::buildData($unit);
        });
    }

    private static function buildData($unit): array
    {
        return [
            'name'   => $unit->name,
            'symbol' => $unit->symbol,
        ];
    }

    public function asParentConversions()
    {
        return $this->hasMany(UnitConversion::class, 'parent_unit_id');
    }

    public function asChildConversions()
    {
        return $this->hasMany(UnitConversion::class, 'child_unit_id');
    }
}
