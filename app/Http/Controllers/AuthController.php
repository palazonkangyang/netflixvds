<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
  public function __construct()
  {
  }

  // Login
  public function login()
  {
    if(!Auth::check())
    {
      return view('account.login');
    }

    else
    {
      return back();
    }
  }

  // Check Auth
  public function postAuthenticate(Request $request)
  {
    $auth = false;
    $credentials = $request->only('username', 'password');

    $user = User::where('username', $credentials['username'])->first();

    if ( !$user ) {
			$request->session()->flash('error', 'Unauthorised User Access !! INVALID User ID or Password !!');
			return redirect()->back();
    }

    elseif($user->role == 2)
    {
      $request->session()->flash('error', 'This role cannot access the system.');
			return redirect()->back();
    }

    elseif (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
      $auth = true;
    }

		else {
			$request->session()->flash('error', 'Unauthorised User Access !! INVALID User ID or Password !!');
			return redirect()->back();
		}

    return redirect()->intended(URL::route('dashboard-page'));
  }

  // Logout
  public function logout()
  {
		Session::flush();
    Auth::logout();

    return redirect()->intended(URL::route('login-page'));
  }
}
