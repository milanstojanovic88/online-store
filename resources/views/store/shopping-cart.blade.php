@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    @if(Session::has('success-message'))
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-success">
                    {{ Session::get('success-message') }}
                </div>
            </div>
        </div>
    @endif
    @if(Session::has('cart_' . md5(Auth::user()->id)))
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <ul class="list-group">
                    @foreach($products as $product)
                        <li class="list-group-item clearfix">
                            <span class="badge pull-right">Quantity:&nbsp;{{ $product['quantity'] }}</span>
                            <strong>{{ $product['item']['name'] }}</strong>
                            <span class="label label-success">&#8364;&nbsp;{{ $product['price'] }}</span>
                            <div class="btn-group">
                                <a href="{{ route('product.removeFromCart', ['id' => $product['item']['id']]) }}" class="btn btn-default btn-sm"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                <a href="{{ route('product.addToCart', ['id' => $product['item']['id']]) }}" class="btn btn-default btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <a href="{{ route('product.deleteFromCart', ['id' => $product['item']['id']]) }}" class="btn btn-default btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <strong>Total: &euro;&nbsp;{{ $totalPrice }}</strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <a href="{{ route('cart.checkout') }}" type="button" class="btn btn-success">Checkout</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2 style="text-align: center">No items in Cart!</h2>
            </div>
        </div>
    @endif
    <br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2 style="text-align: center">Previous orders</h2>
            <hr>
            @if($previous_orders)

                @foreach($previous_orders as $previous_order)
                    <div class="previous-orders-block">
                        <div class="previous-orders-header clearfix" style="margin-bottom: 10px;">
                            <div class="previous-order-description pull-left">
                                Purchased on: {{ $previous_order->created_at }}
                            </div>
                            <div class="previous-orders-tools pull-right">
                                <a href="#">Report a problem</a>
                            </div>
                        </div>
                        <ul class="list-group">
                            @foreach(unserialize($previous_order->cart)->items as $cart)
                                <li class="list-group-item">
                                    {{--{{ dd($cart) }}--}}
                                    <strong>{{ $cart['item']['name'] }}</strong>
                                    <span class="label label-success">Total price:&nbsp;&euro;&nbsp;{{ $cart['price'] }}</span>
                                    <span class="badge">Quantity:&nbsp;{{ $cart['quantity'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

            @endif
        </div>
    </div>

@endsection