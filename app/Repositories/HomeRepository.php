<?php

namespace App\Repositories;

use App\Interfaces\HomeInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;

class HomeRepository implements HomeInterface
{
    public function getBanners()
    {
        return Banner::where('is_active', true)->get();
    }

    public function getExclusiveOffers(int $limit = 5)
    {
        return Product::with(['images'])->where('is_exclusive', true)->take($limit)->get();
    }

    public function getBestSelling(int $limit = 5)
    {
        return Product::with(['images'])->where('is_best_selling', true)->take($limit)->get();
    }

    public function getCategories(int $limit = 4)
    {
        return Category::take($limit)->get();
    }
}