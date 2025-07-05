<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'id',
        'tipe',
        'nama_kategori',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kategori_id');
    }
}
