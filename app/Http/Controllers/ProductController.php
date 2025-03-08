<?php

namespace App\Http\Controllers;



use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'messege'   => 'success',
            'data'=> ProductResource::collection($products)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image', 'public');
        } else {
            return response()->json(['error' => 'Image upload failed'], 500);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->image = $imagePath;
        $product->save();

        return response()->json([
            'message' => 'success',
            'status' => 200,
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $one_product=Product::find($id);
        if(!$one_product){
            return response()->json([
                'message'   => 'product not found',
            ]);
        }
        return response()->json([
            'message'   => 'success',
            'status'   => 200,
            'data'=>   new ProductResource($one_product)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
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
    public function productOFcategore(request $request)
    {
        $id =$request->category_id;
        $roducts_of_categore=Categorie::with('products')->find($id);
        if(!$roducts_of_categore){
            return response()->json([
                'message'   => 'product not found',
            ]);
        }
        return response()->json([
            'message'   => 'success',
            'status'   => 200,
            'data'=>  $roducts_of_categore
        ]);
    }
}
