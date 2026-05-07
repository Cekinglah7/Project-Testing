<?php

namespace App\Interfaces;

interface CartInterface
{
    public function findCartItem($userId, $productId);
    public function incrementQuantity($cartItem, $amount = 1);
    public function createCartItem($data);
    public function reduceQuantity($cartItem, $amount = 1);
    public function deleteCartItem($cartItem);
}
