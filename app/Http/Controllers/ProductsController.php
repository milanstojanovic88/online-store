<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function getSearch(Request $request)
    {
    	$condition = $request['search-products'];

        $results = Product::where('name', 'LIKE', '%' . $condition . '%')
	        ->orWhere('price', 'LIKE', '%' . $condition . '%')
	        ->orWhere('description', 'LIKE', '%' . $condition . '%')
	        ->where('category_id', '=', $request['category-field'])
            ->paginate(16);

	    return view('store.search')->with('results', $results);
    }

    public function getSingleProduct($product_name)
    {
        $product = Product::where('name', '=', $product_name)->first();

	    return view('store.single-product')->with('product', $product);
    }
}
