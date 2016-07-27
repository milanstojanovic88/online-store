@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::to('src/css/splash-screen.css') }}">
@endsection

@section('title')
    Welcome to Store!
@endsection

@section('splash-screen')
    <div class="splash-screen"> {{-- don't forget to remove display attribute --}}
        <div class="splash-screen-content">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
                            <p class="splash-screen-tagline center-block">
                                Welcome to our Store!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <span class="sr-only">0% Complete</span>
                            </div>
                        </div>
                        <div class="continue-to-store" style="display: none">
                            <button class="btn btn-purple btn-large center-block">Continue to Store</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="animationWidth" value="0" style="position: absolute; top: -9999px">

@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <div class="home-page-title">
                <h1>Welcome to our Store!</h1>
            </div>
            @if(Session::has('success-message'))
                <div class="alert alert-success">
                    {{ Session::get('success-message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-10">
            <div class="info-block info-block-bordered clearfix">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum illo in maiores officiis quo? Alias architecto error eum non tempora? Eius necessitatibus perspiciatis placeat reiciendis. Aut corporis maiores sed unde!
                <br><br>
                <a href="{{ route('store.products') }}" class="btn btn-purple btn-large btn-oval pull-right">Browse Store</a>
            </div>
        </div>
        <div class="col-md-6 col-sm-10">
            <div class="info-block info-block-bordered clearfix">
                Click on a button below and become our new member.
                By becoming our member you gain possibility of purchasing various
                products that you like.
                <br><br>
                <a href="{{ route('user.register') }}" class="btn btn-primary btn-large btn-oval pull-right">Register Account</a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ URL::to('src/js/splash.js') }}"></script>
@endsection