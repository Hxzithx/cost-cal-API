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
        'is_delete',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function ($supplier) {
            // Grab all attributes before saving
            $attributes = $supplier->getAttributes();

            // Optionally remove internal fields you don’t want in JSON
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

            $supplier->data = $attributes;
        });
    }

    public static function buildData($supplier): array
    {
        $attributes = $supplier->getAttributes();
        unset($attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);
        return $attributes;
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
