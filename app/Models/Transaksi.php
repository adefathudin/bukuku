<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'kategori_id',
        'tanggal',
        'jumlah',
        'deskripsi',
        'tipe'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('keterangan', 'like', '%' . $filters['search'] . '%');
        }
        
        if ($filters['kategori_id'] ?? false) {
            $query->where('kategori_id', $filters['kategori_id']);
        }
        
        if ($filters['tanggal'] ?? false) {
            $query->whereDate('tanggal', $filters['tanggal']);
        }
    }
}
