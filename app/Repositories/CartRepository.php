<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Interfaces\CartInterface;

class CartRepository implements CartInterface
{
    public function findCartItem($userId, $productId)
    {
        return Cart::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->first();
    }

    public function incrementQuantity($cartItem, $amount = 1)
    {
        return $cartItem->increment('quantity', $amount);
    }

    public function createCartItem($data)
    {
        return Cart::create($data);
    }

    public function reduceQuantity($cartItem, $amount = 1)
    {
        return $cartItem->decrement('quantity', $amount);
    }

    public function deleteCartItem($cartItem)
    {
        return $cartItem->delete();
    }
}