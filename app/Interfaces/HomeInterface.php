<?php

namespace App\Interfaces;

interface HomeInterface
{
    public function getBanners();
    public function getExclusiveOffers(int $limit);
    public function getBestSelling(int $limit);
    public function getCategories(int $limit);
}
