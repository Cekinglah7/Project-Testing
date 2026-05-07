<?php

namespace App\Services;

use App\Interfaces\CategoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories($search = null)
    {
        return $this->categoryRepository->getAllCategories($search);
    }
}