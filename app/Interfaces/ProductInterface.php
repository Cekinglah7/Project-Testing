<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getProductsByCategoryId($categoryId = null);
    public function getProductDetail($id);
    public function deleteProduct($id);
}
