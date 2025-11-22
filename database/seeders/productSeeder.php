<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            //  Chocolates
            [
                'slug' => 'luxury-chocolate-box',
                'name' => 'Luxury Chocolate Box',
                'price' => 1500,
                'category' => 'chocolates',
                'image' => 'luxury-chocolate-box.jpg',
                'description' => 'A premium assortment of dark and milk chocolates.'
            ],
            [
                'slug' => 'milk-chocolate-delight',
                'name' => 'Milk Chocolate Delight',
                'price' => 900,
                'category' => 'chocolates',
                'image' => 'milk-chocolate-delight.jpg',
                'description' => 'Smooth milk chocolates for every sweet lover.'
            ],
            [
                'slug' => 'dark-chocolate-collection',
                'name' => 'Dark Chocolate Collection',
                'price' => 1200,
                'category' => 'chocolates',
                'image' => 'dark-chocolate-collection.jpg',
                'description' => 'Elegant box with assorted dark chocolates.'
            ],
            [
                'slug' => 'hazelnut-chocolates',
                'name' => 'Hazelnut Chocolates',
                'price' => 1100,
                'category' => 'chocolates',
                'image' => 'hazelnut-chocolates.jpg',
                'description' => 'Rich hazelnut-filled chocolate bites.'
            ],

            //  Roses
            [
                'slug' => 'red-rose-bouquet',
                'name' => 'Red Rose Bouquet',
                'price' => 800,
                'category' => 'roses',
                'image' => 'red-rose-bouquet.jpg',
                'description' => 'Classic red roses for your loved one.'
            ],
            [
                'slug' => 'pink-rose-bunch',
                'name' => 'Pink Rose Bunch',
                'price' => 950,
                'category' => 'roses',
                'image' => 'pink-rose-bunch.jpg',
                'description' => 'Elegant bunch of soft pink roses.'
            ],
            
            [
                'slug' => 'mixed-rose-basket',
                'name' => 'Mixed Rose Basket',
                'price' => 1300,
                'category' => 'roses',
                'image' => 'mixed-rose-basket.jpg',
                'description' => 'Basket of red, white, and pink roses.'
            ],
            [
                'slug' => 'yellow-roses',
                'name' => 'Yellow Roses',
                'price' => 850,
                'category' => 'roses',
                'image' => 'yellow-roses.jpg',
                'description' => 'Bright yellow roses representing friendship.'
            ],

            //  Candles
            [
                'slug' => 'scented-candle-set',
                'name' => 'Scented Candle Set',
                'price' => 700,
                'category' => 'candles',
                'image' => 'scented-candle-set.jpg',
                'description' => 'Aromatic candle set with lavender, rose & vanilla.'
            ],
            
            [
                'slug' => 'lavender-candle',
                'name' => 'Lavender Candle',
                'price' => 450,
                'category' => 'candles',
                'image' => 'lavender-candle.jpg',
                'description' => 'Soothing lavender fragrance for peace of mind.'
            ],
            [
                'slug' => 'rose-candle',
                'name' => 'Rose Candle',
                'price' => 480,
                'category' => 'candles',
                'image' => 'rose-candle.jpg',
                'description' => 'Romantic rose-scented candle for special evenings.'
            ],
            [
                'slug' => 'candle-gift-box',
                'name' => 'Candle Gift Box',
                'price' => 900,
                'category' => 'candles',
                'image' => 'candle-gift-box.jpg',
                'description' => 'Premium set of decorative gift candles.'
            ],

            //  Mugs
            [
                'slug' => 'personalized-mug',
                'name' => 'Personalized Mug',
                'price' => 900,
                'category' => 'mugs',
                'image' => 'personalized-mug.jpg',
                'description' => 'Custom text or photo printed on a ceramic mug.'
            ],
            [
                'slug' => 'couple-mug-set',
                'name' => 'Couple Mug Set',
                'price' => 1100,
                'category' => 'mugs',
                'image' => 'couple-mug-set.jpg',
                'description' => 'Matching mugs for couples.'
            ],
            
            [
                'slug' => 'heart-handle-mug',
                'name' => 'Heart Handle Mug',
                'price' => 850,
                'category' => 'mugs',
                'image' => 'heart-handle-mug.jpg',
                'description' => 'Cute mug with heart-shaped handle.'
            ],
            [
                'slug' => 'gift-box-mug',
                'name' => 'Gift Box Mug',
                'price' => 950,
                'category' => 'mugs',
                'image' => 'gift-box-mug.jpg',
                'description' => 'Elegant mug packed in a premium gift box.'
            ],
        ];

        // Insert each product into database
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
