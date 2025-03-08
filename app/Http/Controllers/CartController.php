<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function addToCart(Request $request)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth('sanctum')->id(),
        ]);


        $existingProduct = $cart->product()->where('product_id', $request->product_id)->first();


        $newQuantity = $existingProduct
            ? $existingProduct->pivot->quantity + $request->quantity
            : $request->quantity;


        $cart->product()->syncWithoutDetaching([
            $request->product_id => ['quantity' => $newQuantity]
        ]);

        $data=CartProduct::where('cart_id',$cart->id)->get();
        return response()->json(['data' =>$data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id)
    {
       $cart=Cart::where('user_id', auth('sanctum')->id())?->first();
       $cart->product()->detach($product_id);
       return response()->json(['Messege' => 'the product has been deleted']);
    }
}
