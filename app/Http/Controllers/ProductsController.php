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

    public function getCart()
    {
	    $userHash = (Auth::check()) ? md5(Auth::user()->id) : null;
        if(!Session::has('cart_' . $userHash)){
        	return view('store.shopping-cart');
        }

        $oldCart = Session::get('cart_' . $userHash);
	    $cart = new Cart($oldCart);

	    return view('store.shopping-cart', [
	    	'products' => $cart->items,
		    'totalPrice' => $cart->totalPrice
	    ]);
    }

	public function getCheckout()
	{
		$userHash = (Auth::check()) ? md5(Auth::user()->id) : null;
		if(!Session::has('cart_' . $userHash)){
			return view('store.shopping-cart');
		}

		$oldCart = Session::get('cart_' . $userHash);
		$cart = new Cart($oldCart);
		$total = $cart->totalPrice;

		return view('store.checkout', ['total' => $total]);
	}

//	public function postCheckout(Request $request)
//	{
//		if(!Session::has('cart')){
//			return redirect()->route('shop.shoppingCart');
//		}
//
//		$oldCart = Session::get('cart');
//		$cart = new Cart($oldCart);
//
//		Stripe::setApiKey('sk_test_GPwltfvPFjyOjJ2nqqRonqiI');
//		try{
//			Charge::create([
//				"amount" => $cart->totalPrice * 100,
//				"currency" => "eur",
//				"source" => $request['stripeToken'], // obtained with Stripe.js
//				"description" => "Test Charge"
//			]);
//		} catch (\Exception $e) {
//			return redirect()->route('checkout')->with('error', $e->getMessage());
//		}
//
//		Session::forget('cart');
//
//		return redirect()->route('product.index')->with('success', 'Successfully purchased products!');
//
//	}
}
