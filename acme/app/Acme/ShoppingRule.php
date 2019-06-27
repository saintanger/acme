<?php

namespace App\Acme;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ShoppingRule extends Model
{


    /**
     * Checks if cart items are applicable for Second product Half Price discount.
     *
     * @param $rule
     * @param $product_codes
     * @param $cart_items
     * @return float|int
     */
    public static function secondHalfPriceDiscount($rule, $product_codes, $cart_items)
    {

        $condition_code = explode(':', $rule->condition);
        $discount = 0;

        if (isset($condition_code[1])) {


            // check if such product code exists in our basket
            if (in_array($condition_code[1], $product_codes)) {


                $conditional_product = Product::where('code', $condition_code[1])->where('status', 1)->first();

                if ($conditional_product) {

                    // find how many there are in the basket
                    $quantity = count(array_keys($cart_items, $conditional_product->id));

                    // to apply only for every second product, we will apply the discount on the amount of products that are in the basket divided on two
                    // and then floor rounded e.g. 2/1 = 1 (product to discount) --------- 3/1 = 1.5 which floored = 1

                    $quantity_to_discount = floor($quantity / 2);

                    $discount = $quantity_to_discount * $conditional_product->price * $rule->discount_amount / 100;


                } else {
                    Log::debug("Rules: Condition not met for: {$rule->id} possibly product code {$condition_code[1]} is disabled or doesn't exist");
                }

            } else {
                Log::debug('Rules: Condition not met for: ' . $rule->id);

            }

        } else {
            Log::error('Rules: bad condition set for Rule ID: ' . $rule->id);
        }

        return $discount;
    }
}
