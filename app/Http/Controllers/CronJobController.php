<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\ScheduleStore;
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

class CronJobController extends Controller
{
  // Get Cronjob Video Download
  public function getCronJobVideoDownload(Request $request, $store_id)
  {
    $timezone = [];

    // Check Year and Month
    $year_path = 'uploads/' . date('Y');
    $month_path = $year_path . '/' . date('m');
    $path = URL::to('/') . '/' . $month_path;

    $today = Carbon::today()->toDateString();

    $videos = ScheduleStore::leftjoin('schedule_video', 'schedule_store.schedule_id', '=', 'schedule_video.schedule_id')
              ->leftjoin('video', 'schedule_video.video_id', '=', 'video.id')
              ->leftjoin('schedule_date', 'schedule_store.schedule_id', '=', 'schedule_date.schedule_id')
              ->where('store_id', $store_id)
              ->where('schedule_date.from_date', '<=', $today)
              ->where('schedule_date.to_date', '>=', $today)
              ->select('video_name', 'video_path', 'schedule_date.time_zone_id')
              ->get();

    if(count($videos) > 0)
    {
      $utc_time = gmdate("H:i");

      $timezone = User::leftjoin('client_setting', 'client_setting.user_id', '=', 'users.id')
                  ->leftjoin('time_zone', 'time_zone.id', '=', 'client_setting.time_zone')
                  ->where('store_id', $store_id)
                  ->select('client_setting.auto_update', 'time_zone.utc')
                  ->get();


      $auto_update = strtotime($timezone[0]->auto_update);
      $utc_time = strtotime($timezone[0]->utc);

      $current_time = $auto_update - $utc_time;

      $timezone[0]->current_time = date("h:i", $current_time);
    }

    foreach($videos as $data)
    {
      $data->full_path = URL::to('/') . $data->video_path . $data->video_name;
    }

    return response()->json([
      'videos' => $videos,
      'timezone' => $timezone
    ]);
  }
}
