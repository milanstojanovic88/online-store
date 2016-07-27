<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Component\HttpFoundation\Response;

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
			'password' => 'required|confirmed|min:6',
			'first_name' => 'alpha',
			'last_name' => 'alpha'
		]);

		$confirmation_code = str_random(30);

		$user = User::create([
			'email' => $request['email'],
			'password' => bcrypt($request['password']),
			'confirmation_code' => $confirmation_code,
			'first_name' => $request['first_name'],
			'last_name' => $request['last_name']
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
	
    public function getUserSettings()
    {
    	$user = Auth::user();

        return view('user.settings')->with('user', $user);
    }
    
    public function postUserImageUpload(Request $request)
    {
        if(Auth::check()) {
        	$user = Auth::user();

	        if($request->hasFile('avatar')) {
	        	$avatar = $request->file('avatar');
		        $filename = md5(time() . str_random(20)) . $avatar->getClientOriginalExtension();
		        $path = storage_path('/app/users/avatars/' . $filename);

		        Image::make($avatar)->resize(300, 300)->save($path);

		        $user->avatar = $filename;
		        $user->save();

		        return redirect()->back()->with('success-message', 'Congratulations. You have uploaded image successfully');
	        }
        }

        return redirect()->back()->with('error-message', 'Image could not be uploaded :( <br> Please Try again later.');
    }
    
    public function getUserAvatar($filename)
    {
        $avatar = Storage::disk('avatars')->get($filename);

	    return new Response($avatar, 200);
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
        	'old_password' => 'required',
	        'new_password' => 'required|min:6|same:password_confirmation'
        ]);

	    $user = Auth::user();

	    if(Hash::check($request['old_password'], $user->password)) {
		    $user->password = bcrypt($request['new_password']);
		    $user->save();

		    return redirect()->back()->with('success-message', 'You have successfully changed your password.');
	    }

	    return redirect()->back()->with('error-message', 'Incorrect Old password!');
    }

    public function postChangeData(Request $request)
    {
        $this->validate($request, [
        	'email' => 'email|unique:users',
	        'first_name' => 'alpha',
	        'last_name' => 'alpha'
        ]);

	    $user = Auth::user();

	    if(!empty($request['first_name']) and isset($request['first_name'])) {
	    	$user->first_name = $request['first_name'];
	    }

	    if(!empty($request['last_name']) and isset($request['last_name'])) {
		    $user->last_name = $request['last_name'];
	    }

	    if(!empty($request['email']) and isset($request['email'])) {
		    $user->email = $request['email'];
	    }

	    $user->save();

	    return redirect()->back()->with('success-message', 'You have successfully changed your data.');
    }
}
