<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        // $roleName = Auth::user()->role;
        return view('users.profile');
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $input = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email|max:250',
            'password' => 'string|min:8|confirmed',
        ]);

        $user->update($input);

        return redirect()->route('profile')
            ->with('success', 'Profile is updated successfully.');
    }
}
