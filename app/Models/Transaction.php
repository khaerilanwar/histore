<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function getPendingSaleMoreThanTenMinutes(): ?Transaction
    {
        return $this->where('status', 'pending')
            ->where('pending_time', '<=', Carbon::now()->subminutes(10))
            ->first();
    }

    public function totalSales($date = null): int
    {
        $date = $date ?: date('Y-m-d');

        return $this->whereDate('transaction_date', $date)->sum('total_price');
    }

    public function totalTransactions($date = null): int
    {
        $date = $date ?: date('Y-m-d');

        return $this
            ->whereDate('transaction_date', $date)
            ->count();
    }

    public function totalSold($date = null): int
    {
        $date = $date ?: date('Y-m-d');

        return $this
            ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->whereDate('transaction_date', $date)
            ->sum('quantity');
    }

    public function scopeDailySales(Builder $query, string $date = null): void
    {
        $date = $date ?: date('Y-m-d');

        $query
            ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->join('products', 'transaction_products.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where(DB::raw('DATE(transactions.transaction_date)'), $date)
            ->select(
                'products.id as id_produk',
                'products.name as nama_produk',
                'categories.name as kategori',
                DB::raw('SUM(transaction_products.quantity) as terjual'),
                'products.stock'
            )
            ->groupBy('products.id')
            ->orderBy('terjual', 'desc');
    }
}
