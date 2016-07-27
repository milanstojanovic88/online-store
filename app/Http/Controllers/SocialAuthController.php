<?php

namespace App\Http\Controllers;

use App\SocialAccountService;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Mockery\CountValidator\Exception;

class SocialAuthController extends Controller
{
	/**
	 * @return mixed
	 */
    public function getFacebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

	/**
	 * @param SocialAccountService $service
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function getFacebookCallback(SocialAccountService $service)
    {
    	try {
		    $user = $service->createOrGetUser(Socialite::driver('facebook')->user(), 'facebook');
	    } catch(Exception $e) {
	    	return redirect()->route('user.login')->with('error-message', 'Something went wrong. Try again later.');
	    }

	    Auth::login($user);

	    return redirect()->route('store.products');
    }

	/**
	 * @return mixed
	 */
    public function getTwitterRedirect()
    {
        return Socialite::driver('twitter')->redirect();
    }

	/**
	 * @param SocialAccountService $service
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function getTwitterCallback(SocialAccountService $service)
    {
	    try {
		    $user = $service->createOrGetUser(Socialite::driver('twitter')->user(), 'twitter');
	    } catch(Exception $e) {
		    return redirect()->route('user.login')->with('error-message', 'Something went wrong. Try again later.');
	    }

	    Auth::login($user);

	    return redirect()->route('store.products');
    }
}
