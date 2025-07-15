<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;


class BrandController extends Controller
{
    public function index(){
        $brands = Brand::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 200,
            'data' => $brands
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();

        return response()->json([
            'status' => 200,
            'message' => 'Brand created successfully',
            'data' => $brand
        ]);
    }

    public function show($id){
        $brand = Brand::find($id);

        if(!$brand){
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Brand found',
            'data' => $brand
        ]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found',
                'data' => []
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // or adjust based on your logic
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ]);
        }

        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();

        return response()->json([
            'status' => 200,
            'message' => 'Brand updated successfully',
            'data' => $brand
        ]);
    }

    public function destroy($id){
        $brand = Brand::find($id);

        if(!$brand){
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found',
                'data' => []
            ]);
        }

        $brand->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Brand deleted successfully',
            'data' => []
        ]);
    }
}
