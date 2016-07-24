@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Browse Categories</h1>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <form action="{{ route('store.search') }}" id="search-products-form" method="get" class="form-inline" style="top: 18px; position: relative">

                <div class="form-group">
                    <input class="form-control input-lg" type="text" name="search-products" id="search-products" placeholder="Search products...">
                </div>
                <input type="hidden" name="category-field" value="">
                <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="product-categories">
            @foreach(DB::table('categories')->get() as $category)

                <div class="col-sm-6 col-md-6">
                    <div class="thumbnail clearfix">
                        <img src="{{ route('category.image', [
                            'filename' => strtolower($category->category_name . '_category.png')
                        ]) }}" alt="..." class="img-responsive">
                        <div class="caption">
                            <h3>{{ $category->category_name }}</h3>
                            <p>{{ $category->description }}</p>
                            <div>
                                <a href="{{ route('category.products', [
                                    'category_name' => strtolower($category->category_name)
                                ]) }}" class="btn btn-primary btn-lg btn-oval pull-right" role="button">Browse {{ $category->category_name }}</a>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

@endsection