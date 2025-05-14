<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function productSubCategories()
    {
        return $this->hasMany(ProductSubCategories::class, 'product_category_id');
    }
}
