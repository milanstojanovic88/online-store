@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::to('/src/css/font-awesome-input.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <h1>Register</h1><br>
            @if(count($errors))
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('error-message'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error-message') }}</p>
                </div>
            @endif
            @if(Session::has('success-message'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success-message') }}</p>
                </div>
            @endif
            <form action="{{ route('user.register') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group clearfix">
                    <input type="email" class="form-control form-control-half pull-left" required name="email" id="email" placeholder="&#xf003;&nbsp;&nbsp;E-mail*:&nbsp;" value="{{ old('email') }}">
                    <input type="email" class="form-control form-control-half pull-right" required name="email_confirmation" id="email_confirmation" placeholder="&#xf003;&nbsp;&nbsp;E-mail confirmation*:&nbsp;" value="{{ old('email_confirmation') }}">
                </div>
                <div class="form-group clearfix">
                    <input type="password" class="form-control form-control-half pull-left" required name="password" id="password" placeholder="&#xf084;&nbsp;&nbsp;Password*:&nbsp;" value="{{ old('password') }}">
                    <input type="password" class="form-control form-control-half pull-right" name="password_confirmation" id="password_confirmation" required placeholder="&#xf084;&nbsp;&nbsp;Password confirmation*:&nbsp;" value="{{ old('password_confirmation') }}">
                </div>
                <div class="form-group clearfix">
                    <input type="text" class="form-control form-control-half pull-left" name="name" id="name" placeholder="&#xf007;&nbsp;&nbsp;Name:&nbsp;" value="{{ old('name') }}">
                </div>
                <button class="btn btn-primary" type="submit">Register&nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
                <button class="btn btn-default" type="reset">Reset&nbsp;<i class="fa fa-times" aria-hidden="true"></i></button>
            </form>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-10 col-sm-offset-1">
            <h5 style="text-align: center">Login with Social Network account.</h5>
            <hr>
            <a href="{{ route('auth.facebook-redirect') }}" class="btn btn-primary btn-facebook">
                <i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;&nbsp;Facebook
            </a>
            <a href="{{ route('auth.twitter-redirect') }}" class="btn btn-primary btn-twitter pull-right">
                <i class="fa fa-twitter" aria-hidden="true"></i>&nbsp;&nbsp;Twitter
            </a>
        </div>
    </div>

@endsection