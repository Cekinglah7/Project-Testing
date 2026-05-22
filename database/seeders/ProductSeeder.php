<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; 
use App\Models\Product;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catBeverages = Category::create([
            'name' => 'Beverages',
            'bg_color' => '#F8F8F8',
            'image' => 'beverages_icon.png'
        ]);

        $catFruits = Category::create([
            'name' => 'Fresh Fruits',
            'bg_color' => '#E5F3EA',
            'image' => 'fruits_icon.png'
        ]);

        // Produk 1: Sprite Can (Beverages)
        $sprite = Product::create([
            'category_id' => $catBeverages->id,
            'name' => 'Sprite Can',
            'unit' => '325ml, Price',
            'price' => 1.50,
            'description' => 'Minuman ringan berkarbonasi rasa lemon dan jeruk nipis.',
            'nutrition_info' => '140 Calories',
            'is_exclusive' => true,
            'is_best_selling' => true,
        ]);
        
        // Gambar Sprite
        ProductImage::create([
            'product_id' => $sprite->id,
            'image_url' => 'sprite_can.png',
            'is_primary' => true
        ]);

        // Produk 2: Diet Coke (Beverages)
        $coke = Product::create([
            'category_id' => $catBeverages->id,
            'name' => 'Diet Coke',
            'unit' => '355ml, Price',
            'price' => 1.99,
            'description' => 'Minuman ringan bebas gula dan kalori.',
            'nutrition_info' => '0 Calories',
            'is_exclusive' => false,
            'is_best_selling' => true,
        ]);

        // Gambar Diet Coke
        ProductImage::create([
            'product_id' => $coke->id,
            'image_url' => 'diet_coke.png',
            'is_primary' => true
        ]);

        // Produk 3: Red Apple (Fruits)
        $apple = Product::create([
            'category_id' => $catFruits->id,
            'name' => 'Red Apple',
            'unit' => '1kg, Price',
            'price' => 4.99,
            'description' => 'Apel merah segar organik pilihan terbaik.',
            'nutrition_info' => '52 Calories per 100g',
            'is_exclusive' => true,
            'is_best_selling' => false,
        ]);

        // Gambar Red Apple
        ProductImage::create([
            'product_id' => $apple->id,
            'image_url' => 'red_apple.png',
            'is_primary' => true
        ]);
    }
}
