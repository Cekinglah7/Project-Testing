<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Interfaces\OrderInterface;

class OrderRepository implements OrderInterface
{
    public function createOrder(array $data)
    {
        return Order::create($data);
    }

    public function createOrderItem(array $data)
    {
        return OrderItem::create($data);
    }

    public function findOrderById(int $orderId)
    {
        return Order::with(['orderItems.product'])->find($orderId);
    }

    public function getUserOrders(int $userId)
    {
        return Order::with(['orderItems.product.images'])
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }  
}