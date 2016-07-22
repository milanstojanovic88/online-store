<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
	public function getLogin()
	{
		return view('user.login');
    }

	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required'
		]);

		if(Auth::attempt([
			'email' => $request['email'],
			'password' => $request['password']
		], $request['remember_me'])) {
			return redirect()->route('store.products');
		}

		return redirect()->back()->with('error-message', 'Incorrect username and/or password!');
    }

	public function getLogout()
	{
		Auth::logout();
		return redirect()->route('user.login');
    }

	public function getRegister()
	{
		return view('user.register');
    }

	public function postRegister(Request $request)
	{
		$this->validate($request, [
			'email' => 'email|required|confirmed|unique:users',
			'password' => 'required|confirmed|min:6'
		]);

		$confirmation_code = str_random(30);

		$user = User::create([
			'email' => $request['email'],
			'password' => bcrypt($request['password']),
			'confirmation_code' => $confirmation_code
		]);

		Mail::send('email.verify', ['user' => $user, 'confirmation_code' => $confirmation_code], function($message) use ($user) {

			$message->from('email@mail.com', 'Verification Email');
			$message->to($user->email)
		        ->subject('Verify your email address');
		});

		return redirect()->route('home')
			->with('success-message', 'Thanks for signing up! Please check your email.');
    }
    
    public function getVerify($confirmation_code)
    {
        if(!$confirmation_code) {
        	return redirect()->route('home');
        }

        $user = new User();
	    $user = $user->where(['confirmation_Code' => $confirmation_code])->first();

//        $user = User::where(['confirmation_code' => $confirmation_code])->first();

	    if(!$user) {
		    return redirect()->route('home');
	    }

	    $user->verified = true;
	    $user->confirmation_code = null;
	    $user->save();

	    return redirect()->route('user.login')
		    ->with('success-message', 'You have successfully verified your account.');
    }
}
