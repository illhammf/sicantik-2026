<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
    ];

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }
}