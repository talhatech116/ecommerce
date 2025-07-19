<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name', 'ASC')->get();
        return response()->json([
            'status' => true,
            'message' => 'Product List',
            'data' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'sku' => 'required',
            'status' => 'required',
            'is_featured' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Product Created',
            'data' => $product
        ], 201);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Product Details',
            'data' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Product Updated',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'Product Deleted',
        ], 200);
    }
}
