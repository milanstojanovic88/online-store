@extends('layouts.master')

@section('title')
    @if(count($products))
        {{ $category = ucfirst($products->first()->category->category_name) }}
    @else
        {{ $category = '' }}
    @endif

@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Browse&nbsp;{{ $category }}</h1>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <form action="{{ route('store.search') }}" id="search-products-form" method="get" class="form-inline" style="top: 18px; position: relative">

                <div class="form-group">
                    @if(count($products))
                        <input class="form-control input-lg" type="text" name="search-products" id="search-products" placeholder="Search {{ $products->first()->category->category_name }}...">
                    @else
                        <input class="form-control input-lg" type="text" name="search-products" id="search-products" placeholder="Search products...">
                    @endif

                </div>
                @if(count($products))
                    <input type="hidden" name="category-field" value="{{ $products->first()->category->id }}">
                @else
                    <input type="hidden" name="category-field" value="">
                @endif
                <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
    <div class="row">

        @if(count($products))
            <div class="col-md-12">
                <nav>
                    {{ $products->render() }}
                </nav>
            </div>
            <div class="category-products">
                @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="thumbnail clearfix">
                            <img src="{{ $product->image_path }}" alt="...">
                            <div class="caption">
                                <h3>{{ $product->name }}</h3>
                                <a href="{{ route('category.products', ['category_name' => $category]) }}"><h4>{{ $category }}</h4></a><br>
                                <p>{{ substr($product->description, 0, 50) }}...&nbsp;<a href="{{ route('single.product', ['product_name' => $product->name]) }}">read more</a></p>
                                <div>
                                    <p class="pull-left"><strong>Price:</strong> &euro; {{ $product->price }}</p>
                                    <a href="{{ route('product.addToCart', ['id' => $product->id]) }}" class="btn btn-success pull-right" role="button">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-12">
                <nav>
                    {{ $products->render() }}
                </nav>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/custom-pagination.js') }}"></script>
@endsection