<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function createOrder(array $data);
    public function createOrderItem(array $data);
    public function findOrderById(int $orderId);
    public function getUserOrders(int $userId);
}
