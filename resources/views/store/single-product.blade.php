@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $product->name }}</h1>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $product->image_path }}" alt="" class="img-responsive img-thumbnail">
            </div>
            <div class="col-md-8">
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>

@endsection