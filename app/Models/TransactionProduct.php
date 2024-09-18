<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TransactionProduct extends Pivot
{
    public $incrementing = true;
    protected $guarded = ['id'];
    protected $with = ['product', 'transaction'];
    protected $table = 'transaction_products';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function getTransactionProduct($transaction_id, $barcode)
    {
        return $this
            ->whereHas('product', function ($query) use ($barcode) {
                $query->where('barcode', $barcode);
            })
            ->where('transaction_id', $transaction_id)
            ->get();
    }
}
