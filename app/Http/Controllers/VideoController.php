<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Video;
use Thumbnail;
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
              ->orderBy('video.date', 'desc')
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

    if(isset($input['from_date']) && isset($input['to_date']))
    {
      $from_date = $input['from_date'];
      $date = str_replace('/', '-', $input['from_date']);
      $FromDate = date("Y-m-d", strtotime($date));

      $to_date = $input['to_date'];
      $date = str_replace('/', '-', $input['to_date']);
      $ToDate = date("Y-m-d", strtotime($date));

      $q->where('video.date', '<=', $FromDate);
      $q->where('video.date', '<=', $ToDate);
    }

    else if(isset($input['from_date']))
    {
      $from_date = $input['from_date'];
      $date = str_replace('/', '-', $input['from_date']);
      $FromDate = date("Y-m-d", strtotime($date));

      $q->where('video.date', '<=', $FromDate);
    }

    else if(isset($input['to_date']))
    {
      $to_date = $input['to_date'];
      $date = str_replace('/', '-', $input['to_date']);
      $ToDate = date("Y-m-d", strtotime($date));

      $q->where('video.date', '<=', $ToDate);
    }

    else{}

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
              ->orderBy('video.date', 'desc')
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

    $year_path = 'uploads/' . date('Y');
    $month_path = $year_path . '/' . date('m');
    $full_path = '/' . $month_path . '/';

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

    if($request->hasFile('file')) {

      $file = $request->file('file');

      $filename = $file->getClientOriginalName();
      $path = $month_path;
      $upload_success = $file->move($path, $filename);

      if ($upload_success) {

        $thumbnail_path = 'uploads/thumb_images';
        $video_path = $month_path .'/'. $filename;
        $thumb_name = strtok($filename, '.');
        $thumbnail_image = $thumb_name . ".jpg";

        $thumbnail_status = Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image, 10);

        if($thumbnail_status)
        {
          $data = [
            'date' => Carbon::now(),
            'code' => $input['code'],
            'title' => $input['title'],
            'video_name' => $filename,
            'thumbnail_name' => $thumbnail_image,
            'video_path' => $full_path,
            'description' => $input['description'],
            'duration' => $input['duration'],
            'category_id' => $input['category_id']
          ];

          Video::create($data);
        }
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

  // Update Video
  public function postEditVideo(Request $request, $id)
  {
    $input = array_except($request->all(), '_token');

    if($request->hasFile('file')) {

      $year_path = 'uploads/' . date('Y');
      $month_path = $year_path . '/' . date('m');
      $full_path = '/' . $month_path . '/';

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

      $file = $request->file('file');

      $filename = $file->getClientOriginalName();
      $path = $month_path;
      $upload_success = $file->move($path, $filename);

      if ($upload_success) {

        $thumbnail_path = 'uploads/thumb_images';
        $video_path = $month_path .'/'. $filename;
        $thumb_name = strtok($filename, '.');
        $thumbnail_image = $thumb_name . ".jpg";

        $thumbnail_status = Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image, 10);

        if($thumbnail_status)
        {
          $video = Video::find($input['id']);
          $video->date = Carbon::now();
          $video->code = $input['code'];
          $video->title = $input['title'];
          $video->video_name = $filename;
          $video->thumbnail_name = $thumbnail_image;
          $video->video_path = $full_path,
          $video->description = $input['description'];
          $video->duration = $input['duration'];
          $video->category_id = $input['category_id'];
          $video->save();
        }
      }
    }

    else
    {
      $video = Video::find($input['id']);
      $video->date = Carbon::now();
      $video->code = $input['code'];
      $video->title = $input['title'];
      $video->description = $input['description'];
      $video->duration = $input['duration'];
      $video->category_id = $input['category_id'];
      $video->save();
    }

    Session::flash('success', 'Video is successfully updated!');
    return redirect()->route('videos-page');
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
