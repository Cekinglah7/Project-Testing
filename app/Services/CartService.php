<?php

namespace App\Services;
use App\Interfaces\CartInterface;

class CartService
{
    protected $cartRepository;

    public function __construct(CartInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function handleAddToCart($userId, $productId, $quantity = 1)
    {
        $cartItem = $this->cartRepository->findCartItem($userId, $productId);

        if ($cartItem) {
            $this->cartRepository->incrementQuantity($cartItem, $quantity);
            return 'Jumlah produk di keranjang diperbarui.';
        }

        $this->cartRepository->createCartItem([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);

        return 'Produk berhasil ditambahkan ke keranjang.';
    }

    public function reduceFromCart($userId, $productId)
    {
        $cartItem = $this->cartRepository->findCartItem($userId, $productId);

        if (!$cartItem) {
            return 'Produk tidak ditemukan di keranjang.';
        }

        if ($cartItem->quantity > 1) {
            $this->cartRepository->reduceQuantity($cartItem, 1);
            return 'Kuantitas produk berhasil dikurangi.';
        } else {
            $this->cartRepository->deleteCartItem($cartItem);
            return 'Produk dihapus dari keranjang.';
        }
    }

    public function removeFromCart($userId, $productId)
    {
        $cartItem = $this->cartRepository->findCartItem($userId, $productId);

        if (!$cartItem) {
            return 'Produk tidak ditemukan di keranjang.';
        }

        $this->cartRepository->deleteCartItem($cartItem);
        
        return 'Produk berhasil dihapus dari keranjang.';
    }
}