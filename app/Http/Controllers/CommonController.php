<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Video;
use App\Models\Partner;
use App\Models\Country;
use App\Models\Store;
use App\Models\User;
use App\Models\ScheduleDate;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class CommonController extends Controller
{
  public function getDashboard()
  {
    $no_of_videos = Video::count();
    $no_of_partners = Partner::count();
    $no_of_stores = Store::count();

    $no_of_schedules = ScheduleDate::leftjoin('schedule_store', 'schedule_store.schedule_id', '=', 'schedule_date.schedule_id')
                       ->leftjoin('schedule_video', 'schedule_video.schedule_id', '=', 'schedule_date.schedule_id')
                       ->count();

    return view('dashboard' , [
      'no_of_videos' => $no_of_videos,
      'no_of_schedules' => $no_of_schedules,
      'no_of_partners' => $no_of_partners,
      'no_of_stores' => $no_of_stores
    ]);
  }

  // Get Video Name
  public function SearchVideoName()
  {
    $title = Input::get('term');
		$results = array();

    $queries = Video::where('title', 'like', '%'.$title.'%')
							 ->orderBy('title', 'asc')
							 ->take(10)
							 ->get();

    foreach ($queries as $query)
		{
			$results[] = [
				'id' => $query->id,
				'value' => $query->title
			];
		}

		return response()->json($results);
  }

  // Get Store Name
  public function SearchStoreName()
  {
    $partner_id = Input::get('partner_id');
    $store_name = Input::get('term');
    // $partner_id = 5;
    // $store_name = "Mac";
		$results = array();

    $queries = Store::leftjoin('country', 'store.country_id', '=', 'country.id')
               ->where('store_name', 'like', '%'.$store_name.'%')
               ->where('partner_id', $partner_id)
							 ->orderBy('store_name', 'asc')
               ->select('store.*', 'country.country_name')
							 ->take(10)
							 ->get();

    foreach ($queries as $query)
		{
			$results[] = [
				'store_id' => $query->id,
        'country_id' => $query->country_id,
        'country_name' => $query->country_name,
				'value' => $query->store_name
			];
		}

		return response()->json($results);
  }

  // Get Country Name
  public function SearchCountryName()
  {
    $country_name = Input::get('term');
		$results = array();

		$queries = Country::where('country_name', 'like', '%'.$country_name.'%')
							 ->orderBy('country_name', 'asc')
							 ->take(10)
							 ->get();

		foreach ($queries as $query)
		{
			$results[] = [
				'id' => $query->id,
				'value' => $query->country_name
			];
		}

		return response()->json($results);
  }

  public function getCountryByPartnerId(Request $request)
  {
    $partner_id = $_GET['partner_id'];

    $countries = Country::leftjoin('partner_country', 'country.id', '=', 'partner_country.country_id')
                 ->where('partner_country.partner_id', $partner_id)
                 ->select('country.id', 'country.country_name')
                 ->get();

    return response()->json(array(
			'countries' => $countries
		));
  }

  public function getStoreByCountryId(Request $request)
  {
    $partner_id = $_GET['partner_id'];
    $country_id = $_GET['country_id'];

    $stores = Store::where('partner_id', $partner_id)
              ->where('country_id', $country_id)
              ->select('id', 'store_name')
              ->get();

    return response()->json(array(
			'stores' => $stores
		));
  }

  public function getStore(Request $request)
  {
    $partner_id = $_GET['partner_id'];
    $country_id = $_GET['country_id'];

    $stores = Store::where('partner_id', $partner_id)
             ->where('country_id', $country_id)
             ->select('store.id', 'store.store_name')
             ->get();

    return response()->json(array(
			'stores' => $stores
		));
  }

  public function CheckUsername(Request $request)
  {
    $username = $_GET['username'];

    $user = User::where('username', $username)->get();

    return response()->json(array(
			'user' => $user
		));
  }
}
