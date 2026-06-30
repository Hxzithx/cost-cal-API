<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class Supplier extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $fillable = [
        'name',
        'external_id',
        'contact_email',
        'contact_phone',
        'is_active',
        'data',
        'is_delete',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($supplier) {
            $supplier->data = self::buildData($supplier);
        });

        static::updating(function ($supplier) {
            $supplier->data = self::buildData($supplier);
        });
    }

    public static function buildData($supplier): array
    {
        return [
            'name' => $supplier->name,
            'external_id' => $supplier->external_id,
            'contact_email' => $supplier->contact_email,
            'contact_phone' => $supplier->contact_phone,
            'is_active' => $supplier->is_active,
        ];
    }

    public static function findOrCreateFromExternal(string $externalId, string $name): self
    {
        return self::firstOrCreate(
            ['external_id' => $externalId],
            ['name' => $name, 'is_active' => true]
        );
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}