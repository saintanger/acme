<?php

use Illuminate\Database\Seeder;

class ShoppingRuleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        echo "Starting Shopping Rules seeding".PHP_EOL;

        $rules = [
            'second_half_price' => [
                'status' => 1,
                'rule_type' => 'second_half_price',
                'condition' => 'SKU:R01',
                'discount_type' => 'percentage',
                'discount_amount' => '50',
                'description' => 'Buy one red widget, get the second half price!',
            ],
        ];

        foreach ($rules as $key => $rule){
            \App\Acme\ShoppingRule::create($rule);
            echo "Shopping Rule $key seeded".PHP_EOL;
        }
        echo "Shopping Rule seeded".PHP_EOL;


    }
}
