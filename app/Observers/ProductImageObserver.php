<?php

namespace App\Observers;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageObserver
{
    public function deleted(ProductImage $productImage): void
    {
        if (Storage::disk('public')->exists('products/' . $productImage->image_url)) {
            Storage::disk('public')->delete('products/' . $productImage->image_url);
        }
    }
}
