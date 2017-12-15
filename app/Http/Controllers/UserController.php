<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Partner;
use App\Models\Country;
use App\Models\Store;
use App\Models\PartnerCountry;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class UserController extends Controller
{
  // Get Users
  public function getUsers()
  {
    $partners = Partner::orderBy('id', 'asc')->get();

    $users = User::leftjoin('partner', 'users.partner_id', '=', 'partner.id')
             ->leftjoin('country', 'users.country_id', '=', 'country.id')
             ->leftjoin('store', 'users.store_id', '=', 'store.id')
             ->select('users.*', 'partner.partner_name', 'country.country_name', 'store.store_name')
             ->orderBy('users.username', 'asc')
             ->paginate(10);

    for($i = 0; $i < count($users); $i++)
    {
      if($users[$i]->role == 0)
      {
        $users[$i]->role_name = "Administrator";
      }

      else if($users[$i]->role == 1)
      {
        $users[$i]->role_name = "Operator";
      }

      else
      {
        $users[$i]->role_name = "Client";
      }

      if($users[$i]->id == Auth::user()->id)
      {
        $users[$i]->login_user = "true";
      }

      else
      {
        $users[$i]->login_user = "false";
      }
    }

    return view('settings.user.index', [
      "partners" => $partners,
      "users" => $users
    ]);
  }

  // Search Users
  public function SearchUsers(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $keyword = "";
    $countries = [];
    $stores = [];

    $partners = Partner::orderBy('id', 'asc')->get();

    $q = User::query();

    if($input['store_id'] != 0)
    {
      $q->where('users.store_id', '=', $input['store_id']);
    }

    if($input['country_id'] != 0)
    {
      $q->where('users.country_id', '=', $input['country_id']);

      $stores = Store::where('country_id', $input['country_id'])->get();
    }

    if($input['partner_id'] != 0)
    {
      $q->where('users.partner_id', '=', $input['partner_id']);

      $countries = PartnerCountry::leftjoin('country', 'partner_country.country_id', '=', 'country.id')
                   ->where('partner_country.partner_id', $input['partner_id'])
                   ->orderBy('country.id', 'asc')
                   ->get();
    }

    if(isset($input['username']))
    {
      $keyword = trim($input['username']);

      $q->where(function($query) use ($keyword){
        $query->where('users.username', 'LIKE', '%'.$keyword.'%');
        $query->orWhere('users.full_name', 'LIKE', '%'.$keyword.'%');
        $query->orWhere('users.email', 'LIKE', '%'.$keyword.'%');
      });
    }

    $users = $q->leftjoin('store', 'users.store_id', '=', 'store.id')
             ->leftjoin('country', 'users.country_id', '=', 'country.id')
             ->leftjoin('partner', 'users.partner_id', '=', 'partner.id')
             ->select('users.*', 'partner.partner_name', 'country.country_name', 'store.store_name')
             ->orderBy('users.username', 'asc')
             ->paginate(10);

    for($i = 0; $i < count($users); $i++)
    {
      if($users[$i]->role == 0)
      {
        $users[$i]->role_name = "Administrator";
      }

      else if($users[$i]->role == 1)
      {
        $users[$i]->role_name = "Operator";
      }

      else
      {
        $users[$i]->role_name = "Client";
      }

      if($users[$i]->id == Auth::user()->id)
      {
        $users[$i]->login_user = "true";
      }

      else
      {
        $users[$i]->login_user = "false";
      }
    }

    return view('settings.user.search-users', [
      "partners" => $partners,
      "users" => $users,
      "countries" => $countries,
      "stores" => $stores,
      "partner_id" => $input['partner_id'],
      "country_id" => $input['country_id'],
      "store_id" => $input['store_id'],
      "keyword" => $keyword
    ]);
  }

  // Get New User
  public function getNewUser()
  {
    $partners = Partner::orderBy('id', 'asc')->get();

    return view('settings.user.new-user', [
      "partners" => $partners
    ]);
  }

  // Add New User
  public function postNewUser(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $input['password'] = Hash::make($input['password']);

    if($input['role'] == 2)
    {
      $input['client_key'] = str_random(16);

      $key = User::where('client_key', $input['client_key'])->first();

      if($key)
      {
        do {
          $input['client_key'] = str_random(16);

        } while ($input['client_key'] == $key->client_key);
      }
    }

    if($input['operator_partner_id'] != 0)
    {
      $input['partner_id'] = $input['operator_partner_id'];
    }

    $result = User::create($input);

    if($input['role'] == 2)
    {
      $user = User::leftjoin('partner', 'users.partner_id', '=', 'partner.id')
              ->leftjoin('country', 'users.country_id', '=', 'country.id')
              ->leftjoin('store', 'users.store_id', '=', 'store.id')
              ->select('users.*', 'partner.partner_name', 'country.country_name', 'store.store_name')
              ->where('users.id', $result->id)
              ->first();

      return view('settings.user.new-client', [
        'user' => $user
      ]);
    }

		$request->session()->flash('success', 'New User successfully added!');
		return redirect()->route('get-users-page');
  }

  // Get Edit User
  public function getEditUser(Request $request, $id)
  {
    $user = User::find($id);

    $partners = Partner::orderBy('id', 'asc')->get();

    $countries = Country::leftjoin('partner_country', 'country.id', '=', 'partner_country.country_id')
                 ->select('country.id', 'country.country_name')
                 ->where('partner_country.partner_id', $user->partner_id)->get();

    $stores = Store::select('id', 'store_name')
              ->where('country_id', $user->country_id)->get();

    return view('settings.user.edit-user', [
      'user' => $user,
      'countries' => $countries,
      'partners' => $partners,
      'stores' => $stores
    ]);
  }

  // Update User
  public function postEditUser(Request $request, $id)
  {
    $input = array_except($request->all(), '_token');

    if(isset($input['password']))
    {
      $input['password'] = Hash::make($input['password']);
    }

    if($input['operator_partner_id'] != 0)
    {
      $input['partner_id'] = $input['operator_partner_id'];
    }

    $user = User::find($input['id']);

    $user->username = $input['username'];

    if(isset($input['password']))
    {
      $user->password = $input['password'];
    }

    if($input['role'] != 2)
    {
      $user->client_key = NULL;
    }

    $user->full_name = $input['full_name'];
    $user->email = $input['email'];
    $user->role = $input['role'];
    $user->partner_id = $input['partner_id'];
    $user->country_id = $input['country_id'];
    $user->store_id = $input['store_id'];
    $user->save();

    $request->session()->flash('success', 'User Account is successfully updated!');
		return redirect()->back();
  }

  // Delete Users
  public function DeleteUsers(Request $request)
  {
    $input = array_except($request->all(), '_token');

    for($i = 0; $i < count($input['id']); $i++)
    {
      $user = User::find($input['id'][$i]);
      $user->delete();
    }

    $request->session()->flash('success', 'Selected Users have been deleted!');
    return redirect()->back();
  }

  // Delete User
  public function getDeleteUser(Request $request, $id)
  {
    $user = User::find($id);

    if (!$user) {
      $request->session()->flash('error', 'Selected User is not found!');
      return redirect()->back();
    }

    $user->delete();

    $request->session()->flash('success', 'Selected User has been deleted!');
    return redirect()->back();
  }
}
