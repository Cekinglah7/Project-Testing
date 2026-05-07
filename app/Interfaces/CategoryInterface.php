<?php

namespace App\Interfaces;

interface CategoryInterface
{
    public function getAllCategories($search = null);
}