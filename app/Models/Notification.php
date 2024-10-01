<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['shop'];
    protected $keyType = 'string';

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function inproducts(): HasMany
    {
        return $this->hasMany(InProduct::class, 'notif_id');
    }

    public function scopeNotificationUser(Builder $query): void
    {
        $query
            ->where(function ($query) {
                $query->where('readable', 0)
                    ->where('status', 'public');
            })
            ->orWhere(function ($query) {
                $query
                    ->where('readable', 0)
                    ->where('status', 'private')
                    ->where('shop_id', Auth::user()->shop_id);
            });
    }
}
