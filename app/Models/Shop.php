<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function stockShops(): HasMany
    {
        return $this->hasMany(StockShop::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function findProductBy($by, $value)
    {
        return $this
            ->where('id', Auth::user()->shop_id)
            ->first()
            ->stockShops()
            ->with('product')
            ->whereHas('product', function ($query) use ($by, $value) {
                $query
                    ->where($by, $value);
            })
            ->first();
    }

    public function scopeShopSearch(Builder $query, $search): void
    {
        $query
            ->where('id', $search)
            ->orWhere('name', 'like', "%{$search}%");
    }

    public function scopeShopStaffById(Builder $query, $id_shop, $search): void
    {
        $query
            ->join('users', 'shops.id', '=', 'users.shop_id')
            ->where('users.status', 'active')
            ->where('users.shop_id', $id_shop)
            ->where(function (Builder $query) use ($search) {
                $query
                    ->where('nik', 'like', "%{$search}%")
                    ->where('name', 'like', "%{$search}%");
            })
            ->select('users.*');
        // ->whereHas('users', function (Builder $query) use ($id_shop, $search) {
        //     $query
        //         ->where('status', 'active')
        //         ->where('shop_id', $id_shop)
        //         ->where(function (Builder $query) use ($search) {
        //             $query
        //                 ->where('nik', 'like', "%{$search}%")
        //                 ->where('name', 'like', "%{$search}%");
        //         });
        // });
    }

    public function scopeInventoryShopById(Builder $query, $id_shop, $search): void
    {
        if ($search) {
            $query
                ->join('stock_shop', 'shops.id', '=', 'stock_shop.shop_id')
                ->join('products', 'stock_shop.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.name as kategori', 'stock_shop.stock', 'shops.id as kode_toko', 'shops.name as nama_toko')
                ->where('shops.id', $id_shop)
                ->where(function (Builder $query) use ($search) {
                    $query
                        ->where('products.barcode', $search)
                        ->orWhere('products.name', 'like', "%{$search}%");
                });
        } else {
            $query
                ->join('stock_shop', 'shops.id', '=', 'stock_shop.shop_id')
                ->join('products', 'stock_shop.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.name as kategori', 'stock_shop.stock', 'shops.id as kode_toko', 'shops.name as nama_toko')
                ->where('shops.id', $id_shop);
        }
    }
}
