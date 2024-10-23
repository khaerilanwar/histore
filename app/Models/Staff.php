<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'ttl',
        'email',
        'no_hp',
        'alamat',
        'salary'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'nik_ktp');
    }
}
