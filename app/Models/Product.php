<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['category'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function scopeByCategory(Builder $query, string $slug): void
    {
        $query->whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        });
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', '%' . $search . '%');
    }
}
