<?php

namespace App\Services;

use App\Interfaces\BrandInterface;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getBrands($search = null)
    {
        return $this->brandRepository->getAllBrands($search);
    }
}