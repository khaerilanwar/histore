<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';
    protected $with = ['user.shop', 'member'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactionProducts(): HasMany
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function getSalesMonthly()
    {
        $year = Carbon::now()->year;

        return $this
            ->whereYear('transactions.transaction_date', $year)
            ->where('status', 'success')
            ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->selectRaw('MONTH(transactions.transaction_date) as month, SUM(transaction_products.subtotal) as sales')
            ->groupBy('month')
            ->get();
    }

    public function getTransactionProcess()
    {
        $user = Auth::user();
        return $this
            ->with(['transactionProducts.product.stockshops' => function ($query) use ($user) {
                $query
                    ->where('shop_id', $user->shop_id);
            }])
            ->where('status', 'process')
            ->where('user_id', Auth::user()->id)
            ->first();
    }

    public function getPendingSaleMoreThanTenMinutes()
    {
        $user = Auth::user();
        return $this
            ->with(['transactionProducts.product.stockshops' => function ($query) use ($user) {
                $query
                    ->where('shop_id', $user->shop_id);
            }])
            ->where('status', 'pending')
            ->where('pending_time', '<=', Carbon::now()->subminutes(10))
            ->where('user_id', Auth::user()->id)
            ->first();
    }

    public function totalSales($date = null): int
    {
        $date = $date ?: date('Y-m-d');

        return $this
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('shops', 'users.shop_id', '=', 'shops.id')
            ->where('shops.id', Auth::user()->shop_id)
            ->whereDate('transactions.transaction_date', $date)
            ->sum('total_price');
    }

    public function totalTransactions($date = null): int
    {
        $date = $date ?: date('Y-m-d');

        return $this
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('shops', 'users.shop_id', '=', 'shops.id')
            ->where('shops.id', Auth::user()->shop_id)
            ->whereDate('transaction_date', $date)
            ->count();
    }

    public function totalSold($date = null): int
    {
        $date = $date ?: date('Y-m-d');

        return $this
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('shops', 'users.shop_id', '=', 'shops.id')
            ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->whereDate('transaction_date', $date)
            ->where('shops.id', Auth::user()->shop_id)
            ->sum('quantity');
    }

    public function scopeDailySales(Builder $query, string $date = null): void
    {
        $date = $date ?: date('Y-m-d');

        $query
            ->join('transaction_products as tp', 'transactions.id', '=', 'tp.transaction_id')
            ->join('products as p', 'tp.product_id', '=', 'p.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('users as u', 'transactions.user_id', '=', 'u.id')
            ->join('shops as s', 'u.shop_id', '=', 's.id')
            ->join('stock_shop as ss', function ($join) {
                $join->on('p.id', '=', 'ss.product_id')
                    ->on('s.id', '=', 'ss.shop_id');
            })
            ->where('s.id', Auth::user()->shop_id)
            ->groupBy('p.id', 's.id', 'ss.stock', 'transactions.transaction_date')
            ->select(
                'p.id as id_produk',
                'p.barcode',
                'p.name as nama_produk',
                'c.name as nama_kategori',
                's.name as nama_toko',
                DB::raw('SUM(tp.quantity) as terjual'),
                'ss.stock as stok_produk'
            )
            ->whereDate('transactions.transaction_date', $date)
            ->orderBy('transactions.transaction_date', 'desc');
    }

    public function scopeDailyHistories(Builder $query, $search = null, $date = null)
    {
        $date = $date ?: date('Y-m-d');
        $user = Auth::user();

        $query
            ->with(['user.shop', 'transactionProducts', 'member'])
            ->whereHas('user', function ($query) use ($user) {
                $query
                    ->where('shop_id', $user->shop_id);
            })
            ->where('transactions.status', 'success')
            ->whereDate('transactions.transaction_date', $date);

        if ($search) {
            $query
                ->where(function (Builder $query) use ($search) {
                    $query->whereHas('member', function (Builder $query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                        ->orWhere('transactions.id', 'like', "%{$search}%");
                });
        }

        $query->orderBy('transactions.transaction_date', 'desc');
    }
}
