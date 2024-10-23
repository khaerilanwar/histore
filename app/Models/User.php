<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $with = ['shop', 'staff'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'password',
        'role',
        'shop_id',
        'nik_ktp',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getUser($by, $value)
    {
        return $this
            ->where($by, $value)
            ->first();
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'nik_ktp', 'nik');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function scopeUserActive(Builder $query, $search): void
    {
        $query
            ->where('status', 'active')
            ->whereHas('staff', function (Builder $query) use ($search) {
                $query
                    ->where('users.nik', 'like', "%{$search}%")
                    ->orWhere('name', 'like',  "%{$search}%");
            });
    }
}
