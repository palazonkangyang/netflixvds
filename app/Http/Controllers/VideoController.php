<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Video;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use File;
use Session;
use View;
use URL;
use Carbon\Carbon;

class VideoController extends Controller
{
  // Video Home Page
  public function index()
  {
    $categories = Category::orderBy('category_name', 'asc')->get();

    $videos = Video::leftjoin('category', 'video.category_id', '=', 'category.id')
              ->select('video.*', 'category.category_name')
              ->paginate(10);

    foreach($videos as $data)
    {
      $data->date = Carbon::parse($data->date)->format("d/m/Y");
    }

    return view('videos.index', [
      'videos' => $videos,
      'categories' => $categories
    ]);
  }

  // Search Videos
  public function SearchVideos(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $from_date = "";
    $to_date = "";

    $categories = Category::orderBy('category_name', 'asc')->get();

    $q = Video::query();

    if(isset($input['from_date']))
    {
      $from_date = $input['from_date'];
      $date = str_replace('/', '-', $input['from_date']);
      $FromDate = date("Y-m-d", strtotime($date));

      $q->where('video.date', '>=', $FromDate);
    }

    if(isset($input['to_date']))
    {
      $to_date = $input['to_date'];
      $date = str_replace('/', '-', $input['to_date']);
      $ToDate = date("Y-m-d", strtotime($date));

      $q->where('video.date', '<=', $ToDate);
    }

    if($input['category_id'] != 0)
    {
      $q->where('video.category_id', '=', $input['category_id']);
    }

    if(isset($input['search_title']))
    {
      $q->where('video.title', 'like', '%' . $input['search_title'] . '%');
    }

    $videos = $q->leftjoin('category', 'video.category_id', '=', 'category.id')
              ->select('video.*', 'category.category_name')
              ->orderBy('id', 'asc')
              ->paginate(10);

    foreach($videos as $data)
    {
      $data->date = Carbon::parse($data->date)->format("d/m/Y");
    }

    return view('videos.search-videos', [
      'from_date' => $from_date,
      'to_date' => $to_date,
      'categories' => $categories,
      'videos' => $videos,
      'category_id' => $input['category_id'],
      'search_title' => $input['search_title']
    ]);
  }

  // Get New Video
  public function getNewVideo()
  {
    $categories = Category::orderBy('category_name', 'asc')->get();

    return view('videos.new-video', [
      'categories' => $categories
    ]);
  }

  // Add New Video
  public function PostNewVideo(Request $request)
  {
    $input = array_except($request->all(), '_token');

    // dd($input['filename'][0]);

    $year_path = 'uploads/' . date('Y');
    $month_path = $year_path . '/' . date('m');

    // Check year folder
    if(!is_dir($year_path))
    {
      mkdir($year_path, 0777);
    }

    // Check month folder
    if(!is_dir($month_path))
    {
      mkdir($month_path, 0777);
    }

    if(isset($input['fileurl']) && count($input['fileurl']))
    {
      $old_path = 'uploads/tmp/' . $input['fileurl'][0];
      $new_path = $month_path . '/' . $input['fileurl'][0];
      $upload_success = File::move($old_path, $new_path);

      if ($upload_success) {

        $data = [
          'date' => Carbon::now(),
          'code' => $input['code'],
          'title' => $input['title'],
          'description' => $input['description'],
          'duration' => $input['duration'],
          'image' => $input['fileurl'][0],
          'category_id' => $input['category_id']
        ];

        Video::create($data);
      }
    }

    Session::flash('success', 'New Video is successfully added!');
    return redirect()->route('videos-page');
  }

  // Get Edit Video
  public function getEditVideo(Request $request, $id)
  {
    $video = Video::find($id);
    $categories = Category::orderBy('category_name', 'asc')->get();

    return view('videos.edit-video', [
      'video' => $video,
      'categories' => $categories
    ]);
  }

  // Delete Videos
  public function DeleteVideos(Request $request)
  {
    $input = array_except($request->all(), '_token');

    for($i = 0; $i < count($input['id']); $i++)
    {
      $video = Video::find($input['id'][$i]);
      $video->delete();
    }

    $request->session()->flash('success', 'Selected Videos have been deleted!');
    return redirect()->back();
  }

  // Delete Video
  public function getDeleteVideo(Request $request, $id)
  {
    $video = Video::find($id);

    if (!$video) {
      $request->session()->flash('error', 'Selected Video is not found!');
      return redirect()->back();
  	}

    $video->delete();

		$request->session()->flash('success', 'Selected Video has been deleted!');
    return redirect()->back();
  }
}
