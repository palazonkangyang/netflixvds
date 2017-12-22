<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Country;
use App\Models\Store;
use App\Models\User;
use App\Models\ClientSetting;
use App\Models\TimeZone;
use App\Models\Partner;
use App\Models\Category;
use App\Models\ScheduleVideo;
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

  public function getSchedules()
  {
    $partners = Partner::all();
    $categories = Category::all();

    return view('client.schedules', [
      'partners' => $partners,
      'categories' => $categories
    ]);
  }

  public function SearchSchedules(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $categories = Category::all();

    $from_date = "";
    $to_date = "";
    $category_id = "";
    $search_title = "";

    $q = ScheduleVideo::query();

    if(isset($input['from_date']) && isset($input['to_date']))
    {
      $from_date = $input['from_date'];
      $fromdate = str_replace('/', '-', $input['from_date']);
      $FromDate = date("Y-m-d", strtotime($fromdate));

      $to_date = $input['to_date'];
      $todate = str_replace('/', '-', $input['to_date']);
      $ToDate = date("Y-m-d", strtotime($todate));

      $q->where(function($query) use ($FromDate, $ToDate){
        $query->whereBetween('schedule_date.from_date', array($FromDate, $ToDate));
        $query->orWhereBetween('schedule_date.to_date', array($FromDate, $ToDate));
      });
    }

    if(isset($input['search_title']))
    {
      $q->where('video.title', 'like', '%' . $input['search_title'] . '%');
      $search_title = $input['search_title'];
    }

    if(isset($input['category_id']))
    {
      $category_id = $input['category_id'];

      if($input['category_id'] != 0)
      {
        $q->where('video.category_id', '=', $input['category_id']);
      }
    }

    $schedules = $q->leftjoin('video', 'video.id', '=', 'schedule_video.video_id')
                 ->leftjoin('schedule_date', 'schedule_date.schedule_id', '=', 'schedule_video.schedule_id')
                 ->leftjoin('schedule_store', 'schedule_store.schedule_id', '=', 'schedule_video.schedule_id')
                 ->leftjoin('category', 'category.id', '=', 'video.category_id')
                 ->leftjoin('schedule', 'schedule.id', '=', 'schedule_video.schedule_id')
                 ->select('schedule_video.schedule_id', 'schedule_date.from_date', 'schedule_date.to_date',
                  'schedule_video.sequence', 'video.title', 'video.thumbnail_name', 'video.duration', 'category.category_name')
                  ->where('schedule_store.store_id', Auth::user()->store_id)
                 ->paginate(10);

    foreach($schedules as $data)
    {
      if(isset($data->from_date))
      {
        $data->from_date = Carbon::parse($data->from_date)->format("d/m/Y");
        $data->date = $data->from_date;
      }

      if(isset($data->to_date))
      {
        $data->to_date = Carbon::parse($data->to_date)->format("d/m/Y");
        $data->date = $data->from_date . ' - ' . $data->to_date;
      }
    }

    return view('client.search-schedules', [
      'from_date' => $from_date,
      'to_date' => $to_date,
      'schedules' => $schedules,
      'categories' => $categories,
      'category_id' => $category_id,
      'search_title' => $search_title
    ]);
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

    $input['auto_update'] = str_replace(' ', '', $input['auto_update']);

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
