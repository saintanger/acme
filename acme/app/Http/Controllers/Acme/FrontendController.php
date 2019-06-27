<?php

namespace App\Http\Controllers\Acme;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{


    public function shopIndex(){

        $products = \App\Acme\Product::where('status',1)->get();
        $rules = \App\Acme\ShoppingRule::where('status',1)->get();

        return view('shop')->with([
            'products' => $products,
            'rules' => $rules,
        ]);

    }
}
