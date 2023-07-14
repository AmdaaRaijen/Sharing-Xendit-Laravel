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
                'image' => 'https://img.freepik.com/free-photo/flip-flop-beach-shoes-yellow-isolated-white-background_1101-2037.jpg?w=1060&t=st=1689323720~exp=1689324320~hmac=a78f84abce823be899268f06c521066290c5f41003a093d6aa711af052ddbb21',
            ],
            [
                'name' => 'Indomie',
                'price' => 20000,
                'image' => 'https://img.freepik.com/free-vector/realistic-chinese-noodles-set_1284-24627.jpg?size=626&ext=jpg&ga=GA1.1.839635355.1689134306&semt=sph'
            ],
            [
                'name' => 'Kulkas 2 pintu minat chat',
                'price' => 3000000,
                'image' => 'https://img.freepik.com/free-vector/refrigerator-closed-opened-door-with-lots-food_1308-103210.jpg?size=626&ext=jpg&ga=GA1.2.839635355.1689134306&semt=sph',
            ],
        ];

        foreach ($data as $product) {
            Product::create($product);
        }
    }
}
