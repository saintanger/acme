@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Browse our products or add by product code below <form method="post" action="{{route('add_by_code')}}"> @csrf <input type="text" name="code" required placeholder="Product Code"> <button type="submit">Add To Cart</button></form></div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="row">
                                    @if ($products)
                                    @foreach ($products as $product)
                                        <div class="col-sm-4">
                                            <div class="card text-center">
                                                <div class="card-header">
                                                    <strong>{{ $product->name }}</strong>
                                                </div>
                                                <div class="card-body">
                                                    <p>Code: {{ $product->code }}</p>
                                                    <h3>${{ $product->price }}</h3>
                                                    <h3>{{ $product->offer }}</h3>

                                                    <a href="{{ route('add_to_cart',['product_id' => $product->id]) }}" class="btn btn-primary">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <div class="col-sm-12">

                                        @if ($rules)
                                            <h3>Hot Deals!</h3>
                                            @foreach ($rules as $rule)
                                                {{ $rule->description }}
                                            @endforeach
                                        @endif

                                        <hr>
                                        @if(Session::get('cart_subtotal'))
                                        <h5>Items</h5>

                                        @foreach(Session::get('cart_product_ids') as $item)

                                            <div>
                                                <span>{{ App\Acme\Product::find($item)->name }}</span>
                                                <span style="float: right;"><a href="{{ route('remove_from_cart', $item) }}">X</a></span>
                                            </div>

                                        @endforeach

                                        <hr>
                                        Subtotal: ${{ Session::get('cart_subtotal') }}
                                        <br>
                                        Discount: ${{ Session::get('cart_discount') }}
                                        <br>
                                        Delivery: ${{ Session::get('cart_delivery') }}
                                        <br>
                                        @if (Session::get('cart_delivery_for_cheaper'))
                                            <hr>
                                            <p>Add products for additional ${{ Session::get('cart_delivery_for_cheaper') }} to get cheaper delivery!</p>
                                        @endif
                                        <hr>
                                        Total: ${{ Session::get('cart_total') }}
                                        @else
                                        No Items in basket yet
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
