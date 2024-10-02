<?php

namespace App\Models;

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
}
