<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'data',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
    ];

        public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}
