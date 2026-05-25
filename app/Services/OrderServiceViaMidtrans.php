<?php

namespace App\Services;

use App\Interfaces\OrderInterface;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\OrderSuccessNotification;
use App\Notifications\OrderFailedNotification;
use Midtrans\Snap;
use Midtrans\Config;

class OrderServiceViaMidtrans
{
    protected $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function getOrderHistory($userId)
    {   
        return $this->orderRepository->getUserOrders($userId);
    }

    public function placeOrder($userId, $requestData)
    {
        $user = User::find($userId);
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            if ($user) {
                $user->notify(new OrderFailedNotification('Keranjang belanja kamu masih kosong', 0));
            }
            throw new \Exception('Keranjang kamu masih kosong!');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        try {
            return DB::transaction(function () use ($userId, $requestData, $cartItems, $subtotal, $user) {
                
                $discount = 0;
                $totalCost = $subtotal - $discount;

                $midtransOrderId = 'WN-' . rand() . '-' . time();

                $order = $this->orderRepository->createOrder([
                    'user_id'         => $userId,
                    'order_id'        => $midtransOrderId,
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

                $midtransParams = [
                    'transaction_details' => [
                        'order_id'     => $midtransOrderId,
                        'gross_amount' => (int) $totalCost,
                    ],
                    'customer_details' => [
                        'first_name' => $user->name ?? 'Pelanggan',
                        'email'      => $user->email ?? 'customer@mail.com',
                        'phone'      => $user->telepon ?? '',
                    ],
                ];

                $snapToken = Snap::getSnapToken($midtransParams);
                $redirectUrl = Snap::getSnapUrl($midtransParams);

                $order->snap_token = $snapToken;
                $order->redirect_url = $redirectUrl;

                Cart::where('user_id', $userId)->delete();

                if ($user) {
                    $user->notify(new OrderSuccessNotification($order->id, $totalCost));
                }

                return $order;
            });

        } catch (\Exception $e) {
            if ($user) {
                $user->notify(new OrderFailedNotification($e->getMessage(), $subtotal));
            }
            
            throw $e;
        }
    }
}