<?php

namespace App\Services;

use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts(array $filters = [])
    {
        return $this->productRepository->getProducts($filters);
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

    public function createProduct(array $data)
    {
        return $this->productRepository->storeProduct($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->productRepository->updateProduct($id, $data);
        if (!$product) {
            throw new \Exception('Produk tidak ditemukan atau gagal diperbarui');
        }
        return $product;
    }
}