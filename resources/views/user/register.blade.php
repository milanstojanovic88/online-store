@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-10 col-sm-offset-1">
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
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" required name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="email_confirmation">Re-enter email</label>
                    <input type="email" class="form-control" required name="email_confirmation" id="email_confirmation">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" required name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Re-enter password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>
                <button class="btn btn-primary" type="submit">Register&nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
                <button class="btn btn-default" type="reset">Reset&nbsp;<i class="fa fa-times" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>

@endsection