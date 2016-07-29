@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::to('/src/css/font-awesome-input.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1>Checkout</h1>
            <h4>Your Total: &euro;{{ $total }}</h4>
            <div id="charge-error" class="alert alert-danger {{ !Session::has('error-message') ? 'hidden' : ''  }}">
                {{ Session::get('error-message') }}
            </div>
            <form action="{{ route('cart.checkout') }}" method="post" id="checkout-form">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input type="text" id="name" name="name" class="form-control" required placeholder="&#xf007;&nbsp;Name:&nbsp;">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input type="text" id="address" name="address" class="form-control" required placeholder="&#xf041;&nbsp;Address:&nbsp;">
                        </div>
                    </div>
                    <hr>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input type="text" id="card-name" class="form-control" required placeholder="&#xf007;&nbsp;Card holder name:&nbsp;">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input type="text" id="card-number" class="form-control" required placeholder="&#xf283;&nbsp;Credit card number:&nbsp;">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <input type="text" id="card-expiry-month" class="form-control" required placeholder="&#xf073;&nbsp;Expiration month:&nbsp;">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <input type="text" id="card-expiry-year" class="form-control" required placeholder="&#xf073;&nbsp;Expiration year:&nbsp;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input type="text" id="card-cvc" class="form-control" required placeholder="&#xf09d;&nbsp;CVC:&nbsp;">
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <button type="submit" class="btn btn-success"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Buy now</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="{{ URL::to('/src/js/checkout.js') }}"></script>
@endsection