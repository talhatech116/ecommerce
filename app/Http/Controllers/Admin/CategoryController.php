<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 200,
            'data' => $categories
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    public function show($id){
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
                'data' => []
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Category found',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
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

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    public function destroy($id){
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
                'data' => []
            ]);
        }

        $category->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully',
            'data' => []
        ]);
    }

}
