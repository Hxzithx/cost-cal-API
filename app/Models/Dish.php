<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Traits\SyncsIsDeleteFlag;

class Dish extends Model
{
    use SoftDeletes, SyncsIsDeleteFlag;

    protected $table = 'dishes';

    protected $fillable = [
        'name',
        'description',
        'data',
        'is_delete',
    ];

    protected $casts = [
        'data' => 'array',
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

    private static function buildData($dish): array
    {
        return [
            'name'        => $dish->name,
            'category_id' => $dish->category_id,
            'description' => $dish->description,
        ];
    }

    public function dishIngredients()
    {
        return $this->hasMany(DishIngredient::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function overheadCosts()
    {
        return $this->hasMany(OverheadCost::class);
    }

    public function laborCosts()
    {
        return $this->hasMany(LaborCost::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'dish_ingredient')
            ->withPivot([
                'default_recipe_qty',
                'unit_id',
                'default_cost_per_unit',
                'cost_unit_id',
                'default_wastage_qty',
                'wastage_unit_id',
                'default_wastage_sell_price',
            ])
            ->withTimestamps();
    }
}
