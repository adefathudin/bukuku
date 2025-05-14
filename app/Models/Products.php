<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Products extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'sub_category_id',
        'stock',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'category_id');
    }
    public function sub_category()
    {
        return $this->belongsTo(ProductSubCategories::class, 'sub_category_id');
    }

}
