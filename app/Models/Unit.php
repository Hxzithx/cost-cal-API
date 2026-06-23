<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class Unit extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $fillable = [
        'name',
        'symbol',
        'data',
        'is_delete',
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
            'name' => $unit->name,
            'symbol' => $unit->symbol,
        ];
    }
}