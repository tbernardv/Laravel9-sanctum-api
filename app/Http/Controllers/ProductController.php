<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();

        if(count($products) > 0){
            return response()->json([
                "message" => "Products listed",
                "data" => $products
            ]);
        } else{
            return response()->json([
                "message" => "None products found!"
            ]); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
            'description' => ['required'],
            'price' => ['required']
        ]);

        $product = Product::create($fields);

        if($product){
            return response()->json([
                "message" => "product stored",
                "product" => $product
            ]);
        } else{
            return response()->json([
                "message" => "Something went wrong!"
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if($product){
            return response()->json([
                "Product" => $product
            ]);
        } else{
            return response()->json([
                "Message" => "No product found!"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
            'description' => ['required'],
            'price' => ['required']
        ]);

        $product = Product::find($id);

        if($product){
            $product->update($fields);
            return response()->json([
                "Message" => "Product updated!",
                "Product" => $product
            ]);
        } else {
            return response()->json([
                "Message" => "Something went wrong!",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::destroy($id);

        if($product){
            return response()->json([
                "message" => "Product deleted!"
            ]);
        }
            return response()->json([
                "message" => "Something went wrong!"
            ]); 
        
    }

    public function search($name){
        $result = Product::where('name', 'like', '%'.$name.'%')
            ->get();

        if(count($result) > 0){
            return response()->json([
                "result" => $result
            ]);
        } else{
            return response()->json([
                "message" => "No products found!"
            ]);
        }
    } 
}
