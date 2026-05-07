<?php

namespace App\Services;

use App\Interfaces\OrderInterface;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrderHistory($userId)
    {   
        return $this->orderRepository->getUserOrders($userId);
    }

    public function placeOrder($userId, $requestData)
    {
        return DB::transaction(function () use ($userId, $requestData) {
            $cartItems = Cart::with('product')->where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Keranjang kamu masih kosong!');
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $discount = 0;
            $totalCost = $subtotal - $discount;

            $order = $this->orderRepository->createOrder([
                'user_id'         => $userId,
                'delivery_method' => $requestData['delivery_method'] ?? null,
                'payment_method'  => $requestData['payment_method'],
                'promo_code'      => $requestData['promo_code'] ?? null,
                'subtotal'        => $subtotal,
                'discount'        => $discount,
                'total_cost'      => $totalCost > 0 ? $totalCost : 0,
                'status'          => 'pending'
            ]);

            foreach ($cartItems as $item) {
                $this->orderRepository->createOrderItem([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
            }

            Cart::where('user_id', $userId)->delete();

            return $order;
        });
    }
}