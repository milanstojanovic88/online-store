@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::to('/src/css/font-awesome-input.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-10 col-sm-offset-1 clearfix">
            <h1>Log In</h1><br>
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
            <form action="{{ route('user.login') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="&#xf003;&nbsp;&nbsp;E-mail:&nbsp;" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="&#xf084;&nbsp;&nbsp;Password:&nbsp;" name="password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember_me" id="remember_me"> Remember me
                    </label>
                    <a href="#" class="pull-right">Forgot your password?</a>
                </div>


                <button class="btn btn-primary" type="submit" name="">Log In&nbsp;<i class="fa fa-sign-in" aria-hidden="true"></i></button>
            </form>
            <br>
            <a href="{{ route('user.register') }}" class="pull-right">Register new user.</a>
        </div>
    </div>

@endsection