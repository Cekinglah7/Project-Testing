<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Interfaces\BrandInterface;

class BrandRepository implements BrandInterface
{
    public function getAllBrands($search = null)
    {
        $query = Brand::query();

        $query->when($search, function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query->get();
    }
}