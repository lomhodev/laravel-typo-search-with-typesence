<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (\App\Models\Category::count() > 0) {
            \App\Models\Category::truncate();
        }
        \App\Models\Category::factory(10)->create();

        // \App\Models\Product::truncate();
        $batchSize = 10000; // Adjust batch size as needed
        $totalProducts = 2000000;

        for ($i = 0; $i < $totalProducts / $batchSize; $i++) {
            \App\Models\Product::factory($batchSize)->create();
            \App\Models\Product::latest('id')->take($batchSize)->get()->each(function ($product) {
                $product->searchable();
            });
        }
    }
}
