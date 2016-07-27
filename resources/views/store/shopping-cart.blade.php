@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    @if(Session::has('cart'))
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <ul class="list-group">
                    @foreach($products as $product)
                        <li class="list-group-item clearfix">
                            <span class="badge">{{ $product['quantity'] }}</span>
                            <strong>{{ $product['item']['name'] }}</strong>
                            <span class="label label-success">&#8364;&nbsp;{{ $product['price'] }}</span>

                            <a href="{{ route('product.removeFromCart', ['id' => $product['item']['id']]) }}" class="btn btn-default btn-sm pull-right"><i class="fa fa-minus" aria-hidden="true"></i></a>
                            <a href="{{ route('product.addToCart', ['id' => $product['item']['id']]) }}" class="btn btn-default btn-sm pull-right"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <strong>Total: &#8364;&nbsp;{{ $totalPrice }}</strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <a href="{{ route('checkout') }}" type="button" class="btn btn-success">Checkout</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2>No items in Cart!</h2>
            </div>
        </div>
    @endif

@endsection