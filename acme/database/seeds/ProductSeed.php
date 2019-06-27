<?php

use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Starting Products seeding".PHP_EOL;

        $products = [
            'R01' => [
                'name' => 'Red Widget',
                'status' => 1,
                'code' => 'R01',
                'price' => '32.95',
            ],
            'G01' => [
                'name' => 'Green Widget',
                'status' => 1,
                'code' => 'G01',
                'price' => '24.95',
            ],
            'B01' => [
                'name' => 'Blue Widget',
                'status' => 1,
                'code' => 'B01',
                'price' => '7.95',
            ],
        ];

        foreach ($products as $key => $product){
            \App\Acme\Product::create($product);
            echo "Product $key seeded".PHP_EOL;
        }
        echo "Products seeded".PHP_EOL;
    }
}
