<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\SMTPSetting;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class GlobalController extends Controller
{
  // Get Partner Lists
  public function getGlobal()
  {
    $settings = SMTPSetting::first();

    return view('settings.global.index', [
      'settings' => $settings
    ]);
  }

  // Update SMTP Settings
  public function postUpdateGlobal(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $settings = SMTPSetting::find($input['id']);
    $settings->host = $input['host'];
    $settings->username = $input['username'];
    $settings->password = $input['password'];
    $settings->port = $input['port'];
    $settings->require_ssl = isset($input['require_ssl']) ? 1 : 0;;
    $settings->save();

    $request->session()->flash('success', 'SMTP Settings have been successfully created!');
		return redirect()->back();
  }
}
