<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Sandal',
                'price' => 10000,
                'image' => 'https://source.unsplash.com/random/300×300',
            ],
            [
                'name' => 'Indomie',
                'price' => 20000,
                'image' => 'https://source.unsplash.com/random/300×300'
            ],
            [
                'name' => 'Kulkas 2 pintu minat chat',
                'price' => 3000000,
                'image' => 'https://source.unsplash.com/random/300×300',
            ],
        ];

        foreach ($data as $product) {
            Product::create($product);
        }
    }
}
