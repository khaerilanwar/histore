<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TransactionProduct extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $with = ['product', 'transaction'];
    protected $table = 'transaction_products';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function getTransactionProduct($transaction_id, $by = 'barcode', $value)
    {
        if ($by === 'barcode') {
            return $this
                ->whereHas('product', function ($query) use ($by, $value) {
                    $query->where($by, $value);
                })
                ->where('transaction_id', $transaction_id)
                ->first();
        } else {
            return $this
                ->where('transaction_id', $transaction_id)
                ->where($by, $value)
                ->first();
        }
    }
}
