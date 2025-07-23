<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{

    public function getProducts(Request $request){
        $products = Product::orderBy('created_at', 'DESC')
                ->where('status', 1)
                ->limit(12);

        //Filter products by category
        if(!empty($request->category)){
            $catArray = explode(',', $request->category);
            $products = $products->whereIn('category_id', $catArray);
        }

        //Filter products by brand
        if(!empty($request->brand)){
            $brandArray = explode(',', $request->brand);
            $products = $products->whereIn('brand_id', $brandArray);
        }

        $products = $products->get();

        //Filter products by brand

        return response()->json($products);
    }

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

    public function getCategories(){
        $categories = Category::orderBy('name', 'ASC')
                                ->where('status', 1)
                                ->get();
        return response()->json($categories);
    }

    public function getBrands(){
        $brands = Brand::orderBy('name', 'ASC')
                        ->where('status', 1)
                        ->get();
        return response()->json($brands);
    }
}
