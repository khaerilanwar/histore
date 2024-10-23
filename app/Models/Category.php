<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function scopeCategorySearch(Builder $query, $search): void
    {
        $query
            ->with('products')
            ->where('name', 'like', "%{$search}%");
    }
}
