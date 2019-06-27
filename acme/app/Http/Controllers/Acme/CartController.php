<?php

namespace App\Http\Controllers\Acme;

use App\Acme\Delivery;
use App\Acme\Product;
use App\Acme\ShoppingRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{


    /**
     * Expects product ID to add to cart
     *
     * @param $product_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart($product_id){

        $product = Product::find($product_id);

        if (!$product){
            Session::flash('status','Failed to find product, please try again');

            return redirect()->back();
        }

        if (!$product->status){
            Session::flash('status','Product is disabled, please try another one');

            return redirect()->back();
        }

        // add to session
        $this->addToCartSession($product_id);

        $this->postCartChanges();

        Session::flash('status',"Product {$product->name} is added to the cart!");

        return redirect()->back();

    }

    /**
     * Actions Post cart changes
     */
    public function postCartChanges() {

        // check shopping rules
        $subtotal = $this->calculateRulesAndSubtotal();
        $delivery_cost = Delivery::calculateDelivery($subtotal);

        $this->calculateTotals($subtotal, $delivery_cost);
    }

    /**
     * Expects product code to add to cart
     *
     * @param $product_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addByCode(Request $request){

        $product = Product::where('code',$request->code)->first();

        if (!$product){
            Session::flash('status','Failed to find product, please try again');

            return redirect()->back();
        }

        if (!$product->status){
            Session::flash('status','Product is disabled, please try another one');

            return redirect()->back();
        }

        // add to session
        $this->addToCartSession($product->id);

        $this->postCartChanges();

        Session::flash('status',"Product {$product->name} is added to the cart!");

        return redirect()->back();

    }
    /**
     * Expects product ID to add to cart
     *
     * @param $product_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromCart($product_id){

        $product = Product::find($product_id);

        if (!$product){
            Session::flash('status','Failed to find product, please try again');

            return redirect()->back();
        }

        // remove from session
        $this->removeFromCartSession($product_id);

        $this->postCartChanges();

        Session::flash('status',"Product {$product->name} is removed from the cart!");

        return redirect()->back();

    }

    /**
     * Adds product id to cart session
     *
     * @param $product_id
     */
    public function addToCartSession($product_id){

        // multi quantity of ids exists within this session key.
        Session::push('cart_product_ids', $product_id);

    }

    /**
     * Eemoves product id to cart session
     *
     * @param $product_id
     */
    public function removeFromCartSession($product_id){

        // multi quantity of ids exists within this session key.

        $cart_array = Session::get('cart_product_ids');
        $key = array_search($product_id, $cart_array);
        if (false !== $key) {
            unset($cart_array[$key]);
        }

        Session::put('cart_product_ids',$cart_array);

    }

    /**
     * Sums totals
     *
     * @param $subtotal
     * @param $delivery_cost
     */
    public function calculateTotals($subtotal,$delivery_cost){

        Session::put('cart_total', $subtotal+$delivery_cost);

    }

    /**
     * Calculates subtotal and applies discounts
     *
     * @return float|int
     */
    public function calculateRulesAndSubtotal(){

        $subtotal = 0;
        $discount = 0;

        $cart_items = Session::get('cart_product_ids');
        $products = Product::findMany($cart_items);

        if ($products) {

            //calculate product price

            foreach ($products as $product){

                // count how many of these product ids are within the cart
                $quantity = count(array_keys( $cart_items, $product->id));
                $subtotal += $product->price * $quantity;
            }

            Session::put('cart_subtotal', $subtotal);

            // get code from all products
            $product_codes = $products->pluck('code')->toArray();
            $rules = ShoppingRule::where('status',1)->get();

            if ($rules){

                foreach ($rules as $rule){

                    // switch for different logic for different types of shopping rules
                    switch ($rule->rule_type){
                        case 'second_half_price':
                            // apply discount for every second product that is in the basket.
                            $discount = ShoppingRule::secondHalfPriceDiscount($rule,$product_codes,$cart_items);

                            break;
                        default:
                            break;

                    }

                }

            }

            $subtotal = $subtotal - $discount;
        }
        Session::put('cart_discount', $discount);

        return $subtotal;

    }



}
