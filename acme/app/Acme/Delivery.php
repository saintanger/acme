<?php

namespace App\Acme;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Delivery extends Model
{
    /**
     * Calculates delivery based on subtotal using the rules stored in the delivery table
     *
     * @param $subtotal
     * @return int
     */
    public static function calculateDelivery($subtotal){

        $delivery_cost = 0;

        if ($subtotal){
            // careful, if two rules exist it will take the first one loaded.
            $deliveries = Delivery::where('min_range', '<', $subtotal)->where('max_range', '>', $subtotal)->get();

            if ($deliveries->count() > 1){
                Log::debug('Deliveries: multiple rules come for similar price range! IDs:' . print_r($deliveries->pluck('id')));
            }

            if ($deliveries->count() < 1){
                Log::warning('Deliveries: No delivery rule found, no delivery costs will be applied.');
                return $delivery_cost;
            }

            $delivery = $deliveries->first();
            $delivery_cost = $delivery->price;




        }
        Session::put('cart_delivery', $delivery_cost);


        // set session key for delivery cost teaser
        if ($delivery_cost > 0){

            Session::put('cart_delivery_for_cheaper', $delivery->max_range - $subtotal);

        } else {

            Session::remove('cart_delivery_for_cheaper');

        }

        return $delivery_cost;

    }
}
