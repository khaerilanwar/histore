<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InProduct extends Model
{
    use HasFactory;

    protected $with = ['notification', 'product'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'notif_id', 'id');
    }
}
