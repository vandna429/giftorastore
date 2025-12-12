<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Chocolates', 'Roses', 'Candles', 'Mugs'];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['name' => $name], // prevent duplicates
                ['slug' => strtolower(str_replace(' ', '-', $name))]
            );
        }
    }
}
