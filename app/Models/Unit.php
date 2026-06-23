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

    protected $fillable = [
        'name',
        'symbol',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function asParentConversions()
    {
        return $this->hasMany(UnitConversion::class, 'parent_unit_id');
    }

    public function asChildConversions()
    {
        return $this->hasMany(UnitConversion::class, 'child_unit_id');
    }
}
