<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SyncsIsDeleteFlag;

class Dish extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $fillable = [
        'name',
        'category_id',
        'description',
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
        static::creating(function ($dish) {
            $dish->data = self::buildData($dish);
        });

        static::updating(function ($dish) {
            $dish->data = self::buildData($dish);
        });
    }

    public static function buildData($dish): array
    {
        $existing = is_array($dish->data) ? $dish->data : [];
        return array_merge($existing, [
            'name' => $dish->name,
            'category_id' => $dish->category_id,
            'description' => $dish->description,
            'is_active' => $dish->is_active,
        ]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dishIngredients()
    {
        return $this->hasMany(DishIngredient::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'dish_ingredient')
            ->withPivot([
                'default_recipe_qty', 'unit_id',
                'default_cost_per_unit', 'cost_unit_id',
                'default_wastage_qty', 'wastage_unit_id',
                'default_wastage_sell_price',
            ])
            ->withTimestamps();
    }

    public function overheadCosts()
    {
        return $this->hasMany(OverheadCost::class);
    }

    public function laborCosts()
    {
        return $this->hasMany(LaborCost::class);
    }
}