<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

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

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if($this->image == "") {
            return "";
        }
        return asset('uploads/products/small/' . $this->image);
    }

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }
}
