@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Search results</h1>
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

        @if(count($results))
            <div class="col-md-12">
                <nav>
                    {{ $results->render() }}
                </nav>
            </div>
            <div class="category-products">
                @foreach($results as $result)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="thumbnail clearfix">
                            <img src="{{ $result->image_path }}" alt="...">
                            <div class="caption">
                                <h3>{{ $result->name }}</h3>
                                <a href="{{ route('category.products', ['category_name' => $result->category->category_name]) }}"><h4>{{ ucfirst($result->category->category_name) }}</h4></a><br>
                                <p>{{ substr($result->description, 0, 50) }}...&nbsp;<a href="{{ route('single.product', ['product_name' => $result->name]) }}">read more</a></p>
                                <div>
                                    <p class="pull-left"><strong>Price:</strong> &euro; {{ $result->price }}</p>
                                    <a href="#" class="btn btn-success pull-right" role="button">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-12">
                <nav>
                    {{ $results->render() }}
                </nav>
            </div>
        @else
        <h2>No results found.</h2>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ URL::to('src/js/custom-pagination.js') }}"></script>
@endsection