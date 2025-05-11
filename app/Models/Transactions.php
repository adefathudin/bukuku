<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionDetails;

class Transactions extends Model
{
    protected $table = "transactions";
    protected $fillable = [
        'receipt_number',
        'transaction_date',
        'total_price',
        'user_id',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'transaction_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];
    public function details()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id', 'id');
    }
}
