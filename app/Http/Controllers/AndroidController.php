<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\ScheduleStore;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class AndroidController extends Controller
{
  // Get Cronjob Video Download
  public function getCronJobVideoDownload(Request $request, $store_id)
  {
    // Check Year and Month
    $year_path = 'uploads/' . date('Y');
    $month_path = $year_path . '/' . date('m');
    $path = URL::to('/') . '/' . $month_path;

    $videos = ScheduleStore::leftjoin('schedule_video', 'schedule_store.schedule_id', '=', 'schedule_video.schedule_id')
              ->leftjoin('video', 'schedule_video.video_id', '=', 'video.id')
              ->where('store_id', $store_id)
              ->select('video_name', 'video_path')
              ->get();

    foreach($videos as $data)
    {
      $data->full_path = URL::to('/') . $data->video_path . $data->video_name;
    }

    return response()->json([
      'videos' => $videos
    ]);
  }
}
