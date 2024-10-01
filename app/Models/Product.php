<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['category'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function inProducts(): HasMany
    {
        return $this->hasMany(InProduct::class);
    }

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function stockShops(): HasMany
    {
        return $this->hasMany(StockShop::class, 'product_id');
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

    public function scopeInventoryShop(Builder $query, $search): void
    {
        $query
            ->join('stock_shop', 'products.id', '=', 'stock_shop.product_id')
            ->where('stock_shop.shop_id', Auth::user()->shop_id)
            ->whereAny(['products.name', 'products.barcode'], 'like', "%{$search}%")
            ->select('products.*', 'stock_shop.stock', 'stock_shop.shop_id')
            ->orderBy('products.name');
    }
}
