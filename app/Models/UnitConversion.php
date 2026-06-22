<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['parent_unit_id', 'child_unit_id', 'factor'])]
class UnitConversion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit_conversation';

    /**
     * Get the parent (base) unit of this conversion.
     */
    public function parentUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'parent_unit_id');
    }

    /**
     * Get the child (target) unit of this conversion.
     */
    public function childUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'child_unit_id');
    }
}
