<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\FavoriteService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\ReduceCartRequest;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(AddToCartRequest $request) 
    {
        $quantity = $request->quantity ?? 1;

        $message = $this->cartService->handleAddToCart(
            Auth::id(), 
            $request->product_id,
            $quantity
        );

        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function reduceCart(ReduceCartRequest $request)
    {
        $message = $this->cartService->reduceFromCart(
            Auth::id(), 
            $request->product_id
        );

        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function addAllFavorites(FavoriteService $favoriteService)
    {
        $userId = Auth::id();
        
        $favorites = $favoriteService->getFavorites($userId);

        if ($favorites->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Daftar favorite kamu masih kosong.'
            ], 404);
        }

        $count = 0;
        foreach ($favorites as $favorite) {
            $this->cartService->handleAddToCart($userId, $favorite->product_id, 1);
            $count++;
        }

        return response()->json([
            'success' => true,
            'message' => "$count produk dari favorite berhasil ditambahkan ke keranjang!"
        ], 200);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $message = $this->cartService->removeFromCart(
            Auth::id(), 
            $request->product_id
        );

        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
