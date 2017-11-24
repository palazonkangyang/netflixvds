<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Country;
use App\Models\Store;
use App\Models\User;
use App\Models\ClientSetting;
use App\Models\TimeZone;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class ClientController extends Controller
{
  // Login
  public function login()
  {
    if(!Auth::check())
    {
      return view('client.login.login');
    }

    else
    {
      return back();
    }
  }

  // Check Authentication
  public function postAuthenticate(Request $request)
  {
    $auth = false;
    $credentials = $request->only('username', 'password');

    $user = User::where('username', $credentials['username'])->first();

    if ( !$user )
    {
			$request->session()->flash('error', 'Unauthorised User Access !! INVALID User ID or Password !!');
			return redirect()->back();
    }

    elseif($user->role != 2)
    {
      $request->session()->flash('error', 'This role cannot access the system.');
			return redirect()->back();
    }

    elseif (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']]))
    {
      $auth = true;

      $country_name = Country::where('id', $user->country_id)->pluck('country_name');
      $store_name = Store::where('id', $user->store_id)->pluck('store_name');

      Session::put('country_name', $country_name[0]);
      Session::put('store_name', $store_name[0]);
    }

    else {
			$request->session()->flash('error', 'Unauthorised User Access !! INVALID User ID or Password !!');
			return redirect()->back();
		}

    return redirect()->intended(URL::route('get-setting-page'));
  }

  // Logout
  public function logout()
  {
    Session::flush();

    Auth::logout();

    return redirect()->intended(URL::route('client-login-page'));
  }

  public function getSetting()
  {
    $user = User::find(Auth::user()->id);
    $client_setting =  ClientSetting::where('user_id', Auth::user()->id)->first();
    $time_zone = TimeZone::all();

    return view('client.setting', [
      'user' => $user,
      'client_setting' => $client_setting,
      'time_zone' => $time_zone
    ]);
  }

  public function postSetting(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $client_setting = ClientSetting::where('user_id', $input['id'])->first();

    if(!isset($client_setting))
    {
      ClientSetting::create($input);
    }

    else
    {
      $client_setting->client_key = $input['client_key'];
      $client_setting->time_zone = $input['time_zone'];
      $client_setting->auto_update = $input['auto_update'];
      $client_setting->user_id = $input['user_id'];
      $client_setting->save();
    }

    $request->session()->flash('success', 'Client Setting is successfully updated!');
		return redirect()->back();
  }
}
