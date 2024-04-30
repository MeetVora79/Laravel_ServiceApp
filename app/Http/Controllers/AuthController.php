<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;




class AuthController extends Controller
{
	public function loadRegister()
	{
		if (Auth::user()) {
			$route = $this->redirectDash();
			return redirect($route);
		}
		return view('register');
	}

	public function register(Request $request)
	{
		$validatedData = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
		
		try {
			$customerExists = Customer::where('email', $validatedData['email'])->exists();
			$staff = Staff::where('email', $validatedData['email'])->first();
			$role = $staff ? $staff->role : 4; 
			
			if (!$customerExists && !$staff) {
				return back()->with('info', 'Only existing customers or staffs can register.')->withInput();
			}
			User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => $request->password,
				'role' => $role,
			]);
			return redirect('/')->with('success', 'Your Registration has been successful.');
		} catch (\Exception $e) {
			return back()->with(['info', 'Registration failed due to a technical issue. Please try again.']);
		}
	}

	public function loadLogin()
	{
		if (Auth::user()) {
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

		if ($user && $Credentials['password'] == $user->password) {
			Auth::login($user);
			$route = $this->redirectDash();
			return redirect($route)->with('Success', 'Congratulation!!, You are Succesfully Login');
		} else {
			return back()->with('error', 'Incorrect Username or Password')->withInput();
		}
	}

	public function redirectDash()
	{

		if (Auth::user()) {

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

	public function forgotPassword()
	{
		return view('forgotpwd');
	}

	public function setPassword(Request $request)
	{
		$request->validate([
			'email' => 'required|email',
			'password' => 'required|string|min:8|confirmed',
		]);

		$user = User::where('email', $request->email)->first();

		if (!$user) {
			return redirect()->back()->with('error', 'The provided email does not match with our records.')->withInput();
		}
		$user->password = $request->password;
		$user->save();
		return redirect('/')->with('success', 'Your Password has been Reset successfully.');
	}

	use AuthenticatesUsers;
}
