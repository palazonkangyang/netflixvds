<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Partner;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class SettingsController extends Controller
{
  public function index()
  {
    return view('settings.index');
  }
}
