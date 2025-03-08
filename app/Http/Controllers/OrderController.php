<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Services\Front\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    // Inject OrderService in the constructor
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Store a newly created order.
     */
    public function CreateOrder(CreateOrderRequest $request)
    {
        return $this->orderService->CreateOrder($request);
    }
    public function removeorder($order_id)
    {
        $order=Order::find($order_id);
        $order->delete();
        return response()->json(['Massege' => 'the order has been deleted']);
    }

}
