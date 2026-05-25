<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getProducts(array $filters = []);
    public function getProductDetail($id);
    public function deleteProduct($id);
    public function reduceQuantity($cartItem, $amount = 1);
    public function deleteCartItem($cartItem);
    public function storeProduct(array $data);
    public function updateProduct($id, array $data);
}
