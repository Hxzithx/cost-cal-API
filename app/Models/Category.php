<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class Category extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $fillable = [
        'name',
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
        static::creating(function ($category) {
            $category->data = self::buildData($category);
        });

        static::updating(function ($category) {
            $category->data = self::buildData($category);
        });
    }

    private static function buildData($category): array
    {
        return [
            'name' => $category->name,
            'is_active' => $category->is_active,
        ];
    }

    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}