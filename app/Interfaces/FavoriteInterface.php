<?php

namespace App\Interfaces;

interface FavoriteInterface
{
    public function getUserFavorites($userId);
    public function checkFavorite($userId, $productId);
    public function addFavorite($userId, $productId);
    public function removeFavorite($favoriteItem);
}
