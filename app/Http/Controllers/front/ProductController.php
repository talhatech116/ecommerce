<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function latestProducts(){
        $products = Product::orderBy('created_at', 'DESC')
                ->where('status', 1)
                ->limit(4)
                ->get();
        return response()->json($products);
    }

    public  function getfeaturedProducts(){
        $products = Product::orderBy('created_at', 'DESC')
                ->where('status', 1)
                ->where('is_featured', 1)
                ->limit(4)
                ->get();
        return response()->json($products);
    }
}
