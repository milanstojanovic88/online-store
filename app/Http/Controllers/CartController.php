<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;
use Stripe\Charge;
use Stripe\Stripe;

class CartController extends Controller
{
	/**
	 * @var
	 */
	private $userHash;


	/**
	 * CartController constructor.
	 */
	public function __construct()
	{
		$this->userHash = (Auth::check()) ? md5(Auth::user()->id) : null;
	}


	/**
	 * Returns cart view
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getCart()
	{
		$user = Auth::user();
		$carts = [];

		if(count($user->orders())){
			$orders = $user->orders()->orderBy('created_at', 'desc')->get();
			foreach ($orders as $order) {
				array_push($carts, $order);
			}
		}

		if(!Session::has('cart_' . $this->userHash)){
			return view('store.shopping-cart', [
				'previous_orders' => $carts
			]);
		}

		$oldCart = Session::get('cart_' . $this->userHash);
		$cart = new Cart($oldCart);

		return view('store.shopping-cart', [
			'products' => $cart->items,
			'totalPrice' => $cart->totalPrice,
			'previous_orders' => $carts
		]);
	}


	/**
	 * Returns checkout view
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getCheckout()
	{;
		if(!Session::has('cart_' . $this->userHash)){
			return view('store.shopping-cart');
		}

		$oldCart = Session::get('cart_' . $this->userHash);
		$cart = new Cart($oldCart);
		$total = $cart->totalPrice;

		return view('store.checkout', ['total' => $total]);
	}


	/**
	 * Cart checkout handler
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postCheckout(Request $request)
	{
	    if(!Session::has('cart_' . $this->userHash)) {
		    return redirect()->route('cart.shoppingCart');
	    }

		$oldCart = Session::get('cart_' . $this->userHash);
		$cart = new Cart($oldCart);

		Stripe::setApiKey('sk_test_GPwltfvPFjyOjJ2nqqRonqiI ');
		try {
			$charge = Charge::create(array(
				"amount" => $cart->totalPrice * 100,
				"currency" => "eur",
				"source" => $request['stripeToken'], // obtained with Stripe.js
				"description" => "Charge for test@example.com"
			));

			$order = new Order();
			$order->cart = serialize($cart);
			$order->address = $request['address'];
			$order->name = $request['name'];
			$order->payment_id = $charge->id;

			Auth::user()->orders()->save($order);
		} catch (\Exception $e) {
			return redirect()->route('cart.checkout')->with('error-message', $e->getMessage());
		}

		Session::forget('cart_' . $this->userHash);

		return redirect()->route('cart.shoppingCart')
			->with('success-message', 'Successfully purchased products!');
	}
}
