<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductInterface;    

class ProductRepository implements ProductInterface
{
    public function getProducts(array $filters = [])
    {
        $query = Product::with(['images']);
        
        if (isset($filters['categories']) && $filters['categories']) {
            $query->where('category_id', $filters['categories']); 
        }

        if (isset($filters['brands']) && $filters['brands']) {
            $query->whereIn('brand_id', (array) $filters['brands']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
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

    public function storeProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($data);
            return $product;
        }
        return null;
    }
}