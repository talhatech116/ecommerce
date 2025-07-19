<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TemporaryImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;




class TempImageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $tempImage = new TemporaryImage();
        $tempImage->image = 'DUMMY';
        $tempImage->save();

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/temp'), $imageName);

        $tempImage->image = $imageName;
        $tempImage->save();

        //Convert Image Thumbnail 
        $manager = new ImageManager(new Driver());
        $img = $manager->read(public_path('uploads/temp/' . $imageName));
        $img->coverDown(400, 450);
        $img->save(public_path('uploads/temp/thumb/' . $imageName));
        

        return response()->json([
            'status' => true,
            'message' => 'Image Uploaded',
            'data' => $tempImage
        ], 200);
    }   
}
