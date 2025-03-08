<?php

namespace App\Services\Front;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Otp;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class OrderService
{

    public function CreateOrder(CreateOrderRequest $request)
    {
        $user = auth('sanctum')->user();
        $cart = Cart::where('user_id', $user->id)->with('product')->first();

        if (!$cart || $cart->product->isEmpty()) {
            return response()->json(['message' => 'The cart is empty'], 400);
        }

        DB::beginTransaction(); // Start database transaction

        try {
            // Calculate the total price
            $totalPrice = $cart->product->reduce(function ($total, $product) {
                return $total + ($product->price * $product->pivot->quantity);
            }, 0);

            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Add products to the order
            foreach ($cart->product as $product) {
                Order_product::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->price,
                ]);
            }

            // Send email to the user
            Mail::raw(
                "Hello {$user->username},\n\n" .
                "Your order has been successfully created!\n" .
                "Order Number: {$order->id}\n" .
                "Total Price: {$totalPrice} USD\n\n" .
                "Thank you for shopping with us!",
                function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Order Confirmation');
                }
            );

            // Clear the cart after order confirmation
            $cart->product()->detach();
            DB::commit(); // Save changes to the database

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order->load('orderProducts') // Load order products
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback changes if an error occurs
            return response()->json(['message' => 'An error occurred while creating the order', 'error' => $e->getMessage()], 500);
        }

    }
    public function removeorder($order_id)
    {
        $order=Order::where('user_id', auth('sanctum')->id())?->first();
        $order->product()->detach($order_id);
        return response()->json(['Massege' => 'the order has been deleted']);
    }



}
