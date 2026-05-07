<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductInterface;    

class ProductRepository implements ProductInterface
{
    public function getProductsByCategoryId($categoryId = null)
    {
        $query = Product::with(['images']);
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate(10);
    }

    public function getProductDetail($id)
    {
        return Product::with(['images', 'reviews'])->withAvg('reviews', 'rating')->find($id);
    }

    public function deleteProduct($id)
    {
        $product = $this->getProductDetail($id);
        if ($product) {
            return $product->delete();
        }
        return false;
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