<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

    public function getAddToCart($id)
    {
    	$userHash = (Auth::check()) ? md5(Auth::user()->id) : null;
		$product = Product::find($id);
	    $oldCart = Session::has('cart_' . $userHash) ? Session::get('cart_' . $userHash) : null;
	    $cart = new Cart($oldCart);
	    $cart->add($product, $product->id);

	    Session::put('cart_' . $userHash, $cart);

	    return redirect()->back();
    }

    public function getRemoveFromCart($id)
    {
	    $userHash = (Auth::check()) ? md5(Auth::user()->id) : null;
	    $product = Product::find($id);
	    $oldCart = Session::has('cart_' . $userHash) ? Session::get('cart_' . $userHash) : null;
	    $cart = new Cart($oldCart);
	    $cart->remove($product, $product->id);

	    Session::put('cart_' . $userHash, $cart);

	    return redirect()->back();
    }
}
