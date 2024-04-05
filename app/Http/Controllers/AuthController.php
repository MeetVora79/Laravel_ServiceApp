<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
	public function loadRegister(){
		if(Auth::user()){
			$route = $this->redirectDash();
			return redirect($route);
		}
		return view('register');
	}

	public function register(Request $request)
    {
       $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

		User::create($validateData);

		return redirect('/')->with('success','Your Registration has been Successfull.');
    }
	public function loadLogin(){
		if(Auth::user()){
			$route = $this->redirectDash();
			return redirect($route);
		}
		return view('login');
	}

	public function login(Request $request)
    {
        $Credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
        ]);

		$user = User::where('email', $Credentials['email'])->first();

		if($user && $Credentials['password'] == $user->password){
			Auth::login($user);
			$route = $this->redirectDash();
			return redirect($route)->with('success','Congratulation!!, You are Succesfully Login');
		}
		else{
			return back()->with('error','Username or Password is Incorrect');
		}
    }

	public function redirectDash(){

		if(Auth::user()){

			switch (Auth::user()->role) {
				case 1:
					return '/admin/dashboard';
				case 2:
					return '/employee/dashboard';
				case 3:
					return '/engineer/dashboard';
				case 4:
					return '/enduser/dashboard';
				default:
					return '/enduser/dashboard';
			}
		}
	}
	public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }
	
    use AuthenticatesUsers;

}
