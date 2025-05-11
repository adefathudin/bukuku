<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'qty',
        'unit_price',
        'subtotal',
    ];
}
