<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price', 
        'compare_price',
        'category_id', 
        'sku', 
        'status', 
        'is_featured',
        'description',
        'short_description',
        'image',
        'brand_id',
        'qty',
        'barcode',
        'is_featured'
    ];
}
