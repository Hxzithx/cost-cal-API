<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'symbol'])]
class Unit extends Model
{
    use HasFactory;

    /**
     * Get conversions where this unit is the parent (base) unit.
     */
    public function conversions(): HasMany
    {
        return $this->hasMany(UnitConversion::class, 'parent_unit_id');
    }
}
