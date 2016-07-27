@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="{{ URL::to('/src/css/font-awesome-input.css') }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>User Settings</h1>
            @if(count($errors))
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('success-message'))
                <div class="alert alert-success">
                    {{ Session::get('success-message') }}
                </div>
            @elseif(Session::has('error-message'))
                <div class="alert alert-danger">
                    {{ Session::get('error-message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 clearfix">
            <div class="profile-image-upload settings-block clearfix">
                <h3>Change your profile picture</h3><br>
                <img src="{{ route('user.avatar', ['filename' => $user->avatar]) }}" alt="user_avatar" class="img-responsive img-circle pull-left" style="width: 150px; height: 150px;">
                <h3>{{ $user->name }}&nbsp;{{ $user->last_name }}'s profile</h3>
                <form method="post" action="{{ route('user.image-upload') }}" enctype="multipart/form-data">
                    <label for="avatar" class="btn btn-default file-upload-control">
                        Choose file&nbsp;&nbsp;<i class="fa fa-upload" aria-hidden="true"></i>
                    </label>
                    <input type="file" id="avatar" name="avatar" style="display: none;">
                    <button class="btn btn-primary" type="submit">
                        Submit image&nbsp;&nbsp;<i class="fa fa-upload" aria-hidden="true"></i>
                    </button>
                    {{ csrf_field() }}<br>

                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="profile-credentials-update settings-block clearfix">
                <h3>Update your credentials</h3><br>
                <div class="col-md-4 col-md-offset-1">
                    <h4>Change your password</h4><br>
                    <form action="{{ route('user.change-password') }}" method="post">
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="&#xf084;&nbsp;&nbsp;Old password" name="old_password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="&#xf044;&nbsp;&nbsp;New password" name="new_password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="&#xf044;&nbsp;&nbsp;Password confirmation" name="password_confirmation">
                        </div>
                        {{ csrf_field() }}
                        <button class="btn btn-primary">Change password&nbsp;&nbsp;<i class="fa fa-pencil" aria-hidden="true"></i></button>
                    </form>
                </div>
                <div class="col-md-4 col-md-offset-2">
                    <h4>Change your profile data</h4><br>
                    <form action="{{ route('user.change-data') }}" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="&#xf003;&nbsp;&nbsp;Email:&nbsp;{{ $user->email }}" name="email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="&#xf007;&nbsp;&nbsp;Name:&nbsp;{{ $user->name }}" name="name">
                        </div>
                        {{ csrf_field() }}
                        <button class="btn btn-primary" type="submit">Change data&nbsp;&nbsp;<i class="fa fa-pencil" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('/src/js/input-file-status.js') }}"></script>
@endsection