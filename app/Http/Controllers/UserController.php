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

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 *
	 * User login view
	 */
	public function getLogin()
	{
		return view('user.login');
    }


	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * User login handler
	 */
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

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * User logout handler
	 */
	public function getLogout()
	{
		Auth::logout();
		return redirect()->route('user.login');
    }

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 *
	 * User register view
	 */
	public function getRegister()
	{
		return view('user.register');
    }

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * User register handler
	 */
	public function postRegister(Request $request)
	{
		$this->validate($request, [
			'email' => 'email|required|confirmed|unique:users',
			'password' => 'required|confirmed|min:6',
			'name' => 'alpha',
			'' => 'alpha'
		]);

		$confirmation_code = str_random(30);

		$user = User::create([
			'email' => $request['email'],
			'password' => bcrypt($request['password']),
			'confirmation_code' => $confirmation_code,
			'name' => $request['name'],
			'' => $request['']
		]);

		Mail::send('email.verify', ['user' => $user, 'confirmation_code' => $confirmation_code], function($message) use ($user) {

			$message->from('email@mail.com', 'Verification Email');
			$message->to($user->email)
		        ->subject('Verify your email address');
		});

		return redirect()->route('store.products')
			->with('success-message', 'Thanks for signing up! Please check your email.');
    }

	/**
	 * @param $confirmation_code
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * User account verification handler
	 */
    public function getVerify($confirmation_code)
    {
        if(!$confirmation_code) {
        	return redirect()->route('home');
        }

        $user = new User();
	    $user = $user->where(['confirmation_Code' => $confirmation_code])->first();

	    if(!$user) {
		    return redirect()->route('home');
	    }

	    $user->verified = true;
	    $user->confirmation_code = null;
	    $user->save();

	    return redirect()->route('user.login')
		    ->with('success-message', 'You have successfully verified your account.');
    }

	/**
	 * @return $this
	 *
	 * User settings view
	 */
    public function getUserSettings()
    {
    	$user = Auth::user();

        return view('user.settings')->with('user', $user);
    }

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * User image upload handler
	 */
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

	/**
	 * @param $filename
	 *
	 * @return Response
	 *
	 * User avatar getter
	 */
    public function getUserAvatar($filename)
    {
        $avatar = Storage::disk('avatars')->get($filename);

	    return new Response($avatar, 200);
    }


	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * User password change handler
	 */
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


	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * User data change handler
	 */
    public function postChangeData(Request $request)
    {
        $this->validate($request, [
        	'email' => 'email|unique:users',
	        'name' => 'alpha'
        ]);

	    $user = Auth::user();

	    if(!empty($request['name']) and isset($request['name'])) {
	    	$user->name = $request['name'];
	    }

	    if(!empty($request['email']) and isset($request['email'])) {
		    $user->email = $request['email'];
	    }

	    $user->save();

	    return redirect()->back()->with('success-message', 'You have successfully changed your data.');
    }
}
