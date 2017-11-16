<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Country;
use App\Models\Store;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class CountryController extends Controller
{
  // Get Country Lists
  public function getCountries()
  {
    $countries = Country::orderBy('id', 'asc')->select(['id', 'country_name'])->paginate(10);

    for($i = 0; $i < count($countries); $i++)
    {
      $store = Store::where('country_id', $countries[$i]->id)->first();
      $user = User::where('country_id', $countries[$i]->id)->first();

      if($store)
      {
        $countries[$i]->editable = "false";
      }

      if($user)
      {
        $countries[$i]->editable = "false";
      }
    }

    return view('settings.country.index', [
      "countries" => $countries
    ]);
  }

  // Search Country
  public function SearchCountries(Request $request)
  {
    $input = array_except($request->all(), '_token');

    if(empty($input))
    {
      $input['country_name'] = "";
    }

    $countries = Country::where('country_name', 'like', '%'. $input['country_name'] .'%')
                 ->paginate(10);

    for($i = 0; $i < count($countries); $i++)
    {
      $store = Store::where('country_id', $countries[$i]->id)->first();
      $user = User::where('country_id', $countries[$i]->id)->first();

      if($store)
      {
        $countries[$i]->editable = "false";
      }

      if($user)
      {
        $countries[$i]->editable = "false";
      }
    }

    return view('settings.country.index', [
			'countries' => $countries,
		]);
  }

  public function getNewCountry()
  {
    return view('settings.country.new-country');
  }

  // Add New Partner
  public function postNewCountry(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $country = Country::where('country_name', $input['country_name'])->first();

    if($country)
		{
			$request->session()->flash('error', "Country Name is already exist!");
			return redirect()->back()->withInput();
		}

    Country::create($input);

		$request->session()->flash('success', 'New Country has been successfully created!');
		return redirect()->back();
  }

  // Edit Partner
  public function getEditCountry(Request $request, $id)
  {
    $country = Country::find($id);

    return view('settings.country.edit-country', [
      'country' => $country
    ]);
  }

  // Update Partner
  public function postEditCountry(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $country = Country::where('country_name', $input['country_name'])
               ->where('id', '!=', $input['id'])
               ->first();

    if($country)
    {
      $request->session()->flash('error', 'Country Name is already exit!');
			return redirect()->back()->withInput();
    }

    $country = Country::find($input['id']);
    $country->country_name = $input['country_name'];

    $country->save();

		$request->session()->flash('success', 'Country Name is successfully updated!');
		return redirect()->back();
  }

  // Delete Countries
  public function DeleteCountries(Request $request)
  {
    $input = array_except($request->all(), '_token');

    for($i = 0; $i < count($input['id']); $i++)
    {
      $country = Country::find($input['id'][$i]);
      $country->delete();
    }

    $request->session()->flash('success', 'Selected Countries have been deleted!');
    return redirect()->back();
  }

  // Delete Country
  public function getDeleteCountry(Request $request, $id)
  {
    $country = Country::find($id);

    if (!$country) {
      $request->session()->flash('error', 'Selected Country is not found!');
      return redirect()->back();
  	}

    $country->delete();

		$request->session()->flash('success', 'Selected Country has been deleted!');
    return redirect()->back();
  }
}
