<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\TemporaryImage;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
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
            'sku' => 'required|unique:products',
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

        if(!empty($request->gallery)){
            foreach($request->gallery as $key => $tempImageId) {
                $tempImage = TemporaryImage::find($tempImageId);
                
                if (!$tempImage) continue;
            
                $extArray = explode('.', $tempImage->image);
                $ext = end($extArray);
                $imageName = $product->id . '-' . uniqid() . '.' . $ext;
            
                $manager = new ImageManager(new Driver());
            
                $originalPath = public_path('uploads/temp/' . $tempImage->image);
            
                try {
                    // Large
                    $img = $manager->read($originalPath);
                    $img->scaleDown(1200);
                    $img->save(public_path('uploads/products/large/' . $imageName));
            
                    // Small
                    $img = $manager->read($originalPath);
                    $img->coverDown(400, 460);
                    $img->save(public_path('uploads/products/small/' . $imageName));

                    $productImage = new ProductImage();
                    $productImage->image = $imageName;
                    $productImage->product_id = $product->id;
                    $productImage->save();

                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Image processing failed',
                        'error' => $e->getMessage()
                    ], 500);
                }
            
                if ($key == 0) {
                    $product->image = $imageName;
                    $product->save();
                }
            
                // Optionally: Save gallery in DB
                // ProductImage::create([
                //     'product_id' => $product->id,
                //     'image' => $imageName
                // ]);
            }
            
            
        }

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
