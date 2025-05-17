<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategories extends Model
{
    protected $table = 'product_sub_categories';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'created_by',
    ];
}
