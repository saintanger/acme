<?php

use Illuminate\Database\Seeder;

class DeliverySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        echo "Starting Deliveries seeding".PHP_EOL;

        $deliveries = [
            'small' => [
                'name' => 'Small delivery',
                'status' => 1,
                'min_range' => '0',
                'max_range' => '50',
                'price' => '4.95',
            ],
            'medium' => [
                'name' => 'Medium delivery',
                'status' => 1,
                'min_range' => '50.0001',
                'max_range' => '90',
                'price' => '2.95',
            ],
            'large' => [
                'name' => 'Large delivery',
                'status' => 1,
                'min_range' => '90.0001',
                'max_range' => '9999999', // if there are bigger orders than this we have nicer problems to have :)
                'price' => '0',
            ],
        ];

        foreach ($deliveries as $key => $delivery){
            \App\Acme\Delivery::create($delivery);
            echo "Delivery $key seeded".PHP_EOL;
        }
        echo "Deliveries seeded".PHP_EOL;


    }
}
