<?php

namespace App\Services;
use App\Interfaces\HomeInterface;

class HomeService
{
    protected $homeRepository;

    public function __construct(HomeInterface $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function getHomeData()
    {
        return [
            'banners'          => $this->homeRepository->getBanners(),
            'exclusive_offers' => $this->homeRepository->getExclusiveOffers(5),
            'best_selling'     => $this->homeRepository->getBestSelling(5),
            'categories'       => $this->homeRepository->getCategories(4),
        ];
    }
}