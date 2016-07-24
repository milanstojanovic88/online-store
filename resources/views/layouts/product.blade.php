@extends('layouts.master')

@section('title')

    {{ $category = ucfirst($products->first()->category->category_name) }}

@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Browse&nbsp;{{ $category }}</h1>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <form action="" id="search-products-form" method="" class="form-inline" style="top: 18px; position: relative">
                <div class="form-group">
                    <input class="form-control input-lg" type="text" name="search-products" id="search-products" placeholder="Search products...">
                </div>
                <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
    <div class="row">
        @foreach($products as $product)
            <div class="category-products">
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail clearfix">
                        <img src="{{ $product->image_path }}" alt="...">
                        <div class="caption">
                            <h3>{{ $product->name }}</h3>
                            <a href="{{ route('category.products', ['category_name' => $category]) }}"><h4>{{ $category }}</h4></a><br>
                            <p>{{ $product->description }}</p>
                            <div>
                                <p class="pull-left"><strong>Price:</strong> &euro; {{ $product->price }}</p>
                                <a href="#" class="btn btn-success pull-right" role="button">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection