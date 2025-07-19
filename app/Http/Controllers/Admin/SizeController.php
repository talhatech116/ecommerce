<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
       $sizes = Size::orderBy('name', 'ASC')->get();
       return response()->json([
        'status' => true,
        'message' => 'Size List',
        'data' => $sizes
       ], 200);
    }


}
