<?php

namespace App\Services;
use App\Interfaces\FavoriteInterface;

class FavoriteService
{
    protected $favoriteRepository;

    public function __construct(FavoriteInterface $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function getFavorites($userId)
    {
        return $this->favoriteRepository->getUserFavorites($userId);
    }

    public function toggleFavorite($userId, $productId)
    {
        $favoriteItem = $this->favoriteRepository->checkFavorite($userId, $productId);

        if ($favoriteItem) {
            $this->favoriteRepository->removeFavorite($favoriteItem);
            return [
                'is_favorited' => false,
                'message' => 'Produk dihapus dari favorite.'
            ];
        }

        $this->favoriteRepository->addFavorite($userId, $productId);
        return [
            'is_favorited' => true,
            'message' => 'Produk berhasil ditambahkan ke favorite.'
        ];
    }
}