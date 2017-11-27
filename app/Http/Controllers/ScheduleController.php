<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Store;
use App\Models\Country;
use App\Models\TimeZone;
use App\Models\Schedule;
use App\Models\ScheduleDate;
use App\Models\ScheduleStore;
use App\Models\ScheduleVideo;
use App\Models\PartnerCountry;
use App\Models\Video;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class ScheduleController extends Controller
{
  public function index()
  {
    $partners = Partner::all();
    $categories = Category::all();

    return view('schedule.index', [
      'partners' => $partners,
      'categories' => $categories
    ]);
  }

  public function getNewSchedule()
  {
    $partners = Partner::orderBy('id', 'asc')->get();
    $time_zone = TimeZone::all();

    return view('schedule.new-schedule', [
      'partners' => $partners,
      'time_zone' => $time_zone
    ]);
  }

  public function PostNewSchedule(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $schedule = [
      'partner_id' => $input['partner_id']
    ];

    $result = Schedule::create($schedule);

    for($i = 0; $i < count($input['date']); $i++)
    {
      if( strpos( $input['date'][$i], '-' ) !== false ) {

        $date = explode("-", $input['date'][$i]);
        $from_date = trim($date[0]);
        $to_date = trim($date[1]);

        $change_from_date = str_replace('/', '-', $from_date);
        $from_date = date("Y-m-d", strtotime($change_from_date));

        $change_to_date = str_replace('/', '-', $to_date);
        $to_date = date("Y-m-d", strtotime($change_to_date));
      }

      else
      {
        $from_date = $input['date'][$i];
        $to_date = NULL;

        $change_from_date = str_replace('/', '-', $from_date);
        $from_date = date("Y-m-d", strtotime($change_from_date));
      }

      $schedule_date = [
        'from_date' => $from_date,
        'to_date' => $to_date,
        'time_zone_id' => $input['timezone_id'][$i],
        'schedule_id' => $result->id
      ];

      ScheduleDate::create($schedule_date);
    }

    for($i = 0; $i < count($input['video_id']); $i++)
    {
      $sequence = $i+ 1;

      $schedule_video = [
        'video_id' => $input['video_id'][$i],
        'sequence' => $sequence,
        'schedule_id' => $result->id
      ];

      ScheduleVideo::create($schedule_video);
    }

    for($i = 0; $i < count($input['store_id']); $i++)
    {
      $schedule_store = [
        'store_id' => $input['store_id'][$i],
        'country_id' => $input['country_id'][$i],
        'schedule_id' => $result->id
      ];

      ScheduleStore::create($schedule_store);
    }

    $request->session()->flash('success', 'New Schedule is successfully created!');
		return redirect()->back();
  }

  public function SearchSchedules(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $partners = Partner::all();
    $categories = Category::all();

    $from_date = "";
    $to_date = "";
    $partner_id = "";
    $country_id = "";
    $store_id = "";
    $category_id = "";
    $search_title = "";

    $countries = [];
    $stores = [];

    $q = ScheduleVideo::query();

    if(isset($input['from_date']))
    {
      $from_date = $input['from_date'];
      $date = str_replace('/', '-', $input['from_date']);
      $FromDate = date("Y-m-d", strtotime($date));

      $to_date = $input['to_date'];
      $date = str_replace('/', '-', $input['to_date']);
      $ToDate = date("Y-m-d", strtotime($date));

      // $q->where('schedule_date.from_date', '<=', $FromDate);
      // $q->whereBetween('schedule_date.from_date', [$FromDate, $ToDate]);
      // $q->orwhere('schedule_date.from_date', '>=', $to_date);
    }

    if(isset($input['to_date']))
    {
      $from_date = $input['from_date'];
      $date = str_replace('/', '-', $input['from_date']);
      $FromDate = date("Y-m-d", strtotime($date));

      $to_date = $input['to_date'];
      $date = str_replace('/', '-', $input['to_date']);
      $ToDate = date("Y-m-d", strtotime($date));

      // $q->orwhere('schedule_date.to_date', '>=', $FromDate);
      // $q->orwhere('schedule_date.to_date', '<=', $to_date);
      // $q->whereBetween('schedule_date.to_date', [$FromDate, $ToDate]);
    }

    if(isset($input['search_title']))
    {
      $q->where('video.title', 'like', '%' . $input['search_title'] . '%');
      $search_title = $input['search_title'];
    }

    if(isset($input['partner_id']))
    {
      $partner_id = $input['partner_id'];

      if($input['partner_id'] != 0)
      {
        $q->where('schedule.partner_id', '=', $input['partner_id']);

        $countries = PartnerCountry::leftjoin('country', 'partner_country.country_id', '=', 'country.id')
                     ->where('partner_country.partner_id', $input['partner_id'])
                     ->orderBy('country.id', 'asc')
                     ->get();
      }
    }

    if(isset($input['country_id']))
    {
      $country_id = $input['country_id'];

      if($input['country_id'] != 0)
      {
        $q->where('schedule_store.country_id', '=', $input['country_id']);

        $stores = Store::where('country_id', $input['country_id'])->get();
      }
    }

    if(isset($input['store_id']))
    {
      $store_id = $input['store_id'];

      if($input['store_id'] != 0)
      {
        $q->where('schedule_store.store_id', '=', $input['store_id']);
      }
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
                 ->leftjoin('store', 'store.id', '=', 'schedule_store.store_id')
                 ->leftjoin('schedule', 'schedule.id', '=', 'schedule_video.schedule_id')
                 ->leftjoin('partner', 'partner.id', '=', 'schedule.partner_id')
                 ->leftjoin('country', 'country.id', '=', 'schedule_store.country_id')
                 ->select('schedule_video.schedule_id', 'partner.partner_name', 'country.country_name', 'store.store_name', 'schedule_date.from_date',
                  'schedule_date.to_date', 'schedule_video.sequence', 'video.title', 'video.duration', 'category.category_name')
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

    return view('schedule.search-schedules', [
      'from_date' => $from_date,
      'to_date' => $to_date,
      'schedules' => $schedules,
      'partners' => $partners,
      'categories' => $categories,
      'partner_id' => $partner_id,
      'country_id' => $country_id,
      'store_id' => $store_id,
      'category_id' => $category_id,
      'search_title' => $search_title,
      'countries' => $countries,
      'stores' => $stores
    ]);
  }

  public function getEditSchedule(Request $request, $id)
  {
    $partners = Partner::all();
    $time_zone = TimeZone::all();

    $schedule = Schedule::find($id);

    $schedule_date = ScheduleDate::leftjoin('time_zone', 'time_zone.id', '=', 'schedule_date.time_zone_id')
                     ->where('schedule_id', $id)
                     ->get();

    $schedule_store = ScheduleStore::leftjoin('store', 'store.id', '=', 'schedule_store.store_id')
                      ->leftjoin('country', 'country.id', '=', 'schedule_store.country_id')
                      ->where('schedule_id', $id)
                      ->get();

    $schedule_video = ScheduleVideo::leftjoin('video', 'video.id', '=', 'schedule_video.video_id')
                      ->where('schedule_id', $id)
                      ->get();

    foreach($schedule_date as $data)
    {
      $from_date = Carbon::parse($data->from_date)->format("d/m/Y");

      if(isset($data->to_date))
      {
        $to_date = Carbon::parse($data->to_date)->format("d/m/Y");

        $data->date = $from_date . ' - ' . $to_date;
      }

      else {
        $date = $from_date;
      }
    }

    return view('schedule.edit-schedule', [
      'partners' => $partners,
      'time_zone' => $time_zone,
      'schedule' => $schedule,
      'schedule_date' => $schedule_date,
      'schedule_store' => $schedule_store,
      'schedule_video' => $schedule_video,
      'partner_id' => $id
    ]);
  }

  public function postEditSchedule(Request $request, $id)
  {
    $input = array_except($request->all(), '_token');

    ScheduleDate::where('schedule_id', $id)->delete();

    for($i = 0; $i < count($input['date']); $i++)
    {
      if( strpos( $input['date'][$i], '-' ) !== false ) {

        $date = explode("-", $input['date'][$i]);
        $from_date = trim($date[0]);
        $to_date = trim($date[1]);

        $change_from_date = str_replace('/', '-', $from_date);
        $from_date = date("Y-m-d", strtotime($change_from_date));

        $change_to_date = str_replace('/', '-', $to_date);
        $to_date = date("Y-m-d", strtotime($change_to_date));
      }

      else
      {
        $from_date = $input['date'][$i];
        $to_date = NULL;

        $change_from_date = str_replace('/', '-', $from_date);
        $from_date = date("Y-m-d", strtotime($change_from_date));
      }

      $schedule_date = [
        'from_date' => $from_date,
        'to_date' => $to_date,
        'time_zone_id' => $input['timezone_id'][$i],
        'schedule_id' => $id
      ];

      ScheduleDate::create($schedule_date);
    }

    ScheduleVideo::where('schedule_id', $id)->delete();

    for($i = 0; $i < count($input['video_id']); $i++)
    {
      $sequence = $i+ 1;

      $schedule_video = [
        'video_id' => $input['video_id'][$i],
        'sequence' => $sequence,
        'schedule_id' => $id
      ];

      ScheduleVideo::create($schedule_video);
    }

    ScheduleStore::where('schedule_id', $id)->delete();

    for($i = 0; $i < count($input['store_id']); $i++)
    {
      $schedule_store = [
        'store_id' => $input['store_id'][$i],
        'country_id' => $input['country_id'][$i],
        'schedule_id' => $id
      ];

      ScheduleStore::create($schedule_store);
    }

    $request->session()->flash('success', 'Selected Schedule is successfully updated!');
		return redirect()->back();
  }

  // public function getDeleteSchedule(Request $request, $id)
  // {
  //   $schedule = Schedule::find($id);
  //
  //   if (!$schedule) {
  //     $request->session()->flash('error', 'Selected Schedule is not found!');
  //     return redirect()->back();
  // 	}
  //
  //   $schedule->delete();
  //
  //   ScheduleDate::where('schedule_id', $id)->delete();
  //   ScheduleStore::where('schedule_id', $id)->delete();
  //   ScheduleVideo::where('schedule_id', $id)->delete();
  //
  //   $request->session()->flash('success', 'Selected Schedule has been deleted!');
  //   return redirect()->back();
  // }
}
