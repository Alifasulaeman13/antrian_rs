<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loket extends Model
{
    protected $fillable = [
        'nama_loket',
        'deskripsi',
        'kode_prefix',
    ];

    public function antrians(): HasMany
    {
        return $this->hasMany(Antrian::class);
    }
}