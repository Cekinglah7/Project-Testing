<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Interfaces\FavoriteInterface;

class FavoriteRepository implements FavoriteInterface
{
    public function getUserFavorites($userId)
    {
        return Favorite::with(['product'])->where('user_id', $userId)->get();
    }

    public function checkFavorite($userId, $productId)
    {
        return Favorite::where('user_id', $userId)
                       ->where('product_id', $productId)
                       ->first();
    }

    public function addFavorite($userId, $productId)
    {
        return Favorite::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    public function removeFavorite($favoriteItem)
    {
        return $favoriteItem->delete();
    }
}