<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::orderBy('name', 'asc')->get();
        
        return response()->json([
            'status' => true,
            'message' => 'success, data found',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:products,name',
            'price' => 'required',
            'description' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' =>  'failed to create',
                'data' => $validator->errors()
            ], 401);
        }
        Product::create([
           'name' => $request->name,
           'price' => $request->price,
           'description' => $request->description 
        ]);
        return response()->json([
            'status' => true,
            'message' => 'successfully added product',
            'data' => $request->all()
        ], 200);
    }   

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
