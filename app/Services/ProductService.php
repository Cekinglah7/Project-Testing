<?php

namespace App\Services;

use App\Interfaces\ProductInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts($categoryId = null)
    {
        return $this->productRepository->getProductsByCategoryId($categoryId);
    }

    public function getDetail($id)
    {
        $product = $this->productRepository->getProductDetail($id);

        if (!$product) {
            throw new \Exception('Produk tidak ditemukan');
        }

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = $this->productRepository->getProductDetail($id);

        if (!$product) {
            throw new \Exception('Produk tidak ditemukan');
        }

        return $this->productRepository->deleteProduct($id);
    }
}