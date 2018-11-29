<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use Socialite;


class LoginController extends Controller
{
    //
	public function __construct() {
		return $this->middleware('guest', ['except'=>'destroy']);
	}

    public function destroy() {
    	auth()->logout();
    	
    	return redirect('bbs')->with('message', '또 방문해 주세요');
    }

    public function create() {
    	return view('sessions.create');
    }

    public function store(Request $request) {
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required|min:6',
		]);
		$user = User::Where('email',$request->email)->first();
		return $user;
		if($user->activated==true){
			if(!auth()->attempt($request->only('email', 'password'), $request->has('remember'))) {
 
				return back()->withInput();
			}
			//Auth::logoutOtherDevices($request->password);
			return redirect()->intended('bbs');
		} else {
			return redirect(route('bbs.index'));
		}
	}  

	public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        // $user->token;
    }

}
