<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Partner;
use App\Models\Country;
use App\Models\Store;
use App\Models\PartnerCountry;
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

class PartnerController extends Controller
{
  // Get Partners
  public function getPartners()
  {
    $partners = Partner::orderBy('id', 'asc')->paginate(10);

    for($i = 0; $i < count($partners); $i++)
    {
      $store = Store::where('partner_id', $partners[$i]->id)->first();
      $user = User::where('partner_id', $partners[$i]->id)->first();

      if($store)
      {
        $partners[$i]->editable = "false";
      }

      if($user)
      {
        $partners[$i]->editable = "false";
      }
    }

    return view('settings.partner.index', [
      'partners' => $partners
    ]);
  }

  // Search Partner
  public function SearchPartners(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $partner_name = "";

    if(isset($input['partner_name']))
    {
      $partner_name = $input['partner_name'];
    }

    $partners = Partner::where('partner_name', 'like', '%'. $partner_name .'%')
                ->orderBy('id', 'asc')
                ->paginate(10);

    for($i = 0; $i < count($partners); $i++)
    {
      $store = Store::where('partner_id', $partners[$i]->id)->first();
      $user = User::where('partner_id', $partners[$i]->id)->first();

      if($store)
      {
        $partners[$i]->editable = "false";
      }

      if($user)
      {
        $partners[$i]->editable = "false";
      }
    }

    return view('settings.partner.index', [
			'partners' => $partners,
		]);
  }

  // Get New Partner
  public function getNewPartner()
  {
    return view('settings.partner.new-partner');
  }

  // Add New Partner
  public function postNewPartner(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $partner = Partner::where('partner_name', $input['partner_name'])->first();

    if($partner)
		{
			$request->session()->flash('error', "Partner Name is already exist!");
			return redirect()->back()->withInput();
		}

    $data = [
      "partner_name" => $input['partner_name']
    ];

    $result = Partner::create($data);

    for($i = 0; $i < count($input['country_id']); $i++)
    {
      $data = [
        "partner_id" => $result->id,
        "country_id" => $input['country_id'][$i]
      ];

      PartnerCountry::create($data);
    }

		$request->session()->flash('success', 'New Partner has been successfully created!');
		return redirect()->back();
  }

  // Edit Partner
  public function getEditPartner(Request $request, $id)
  {
    $partner = Partner::find($id);

    $countries = Country::leftjoin('partner_country', 'country.id', '=', 'partner_country.country_id')
                 ->where('partner_country.partner_id', $id)
                 ->select('country.id', 'country.country_name')
                 ->get();

    return view('settings.partner.edit-partner', [
      'partner' => $partner,
      'countries' => $countries
    ]);
  }

  // Update Partner
  public function postEditPartner(Request $request, $id)
  {
    $input = array_except($request->all(), '_token');

    $partner = Partner::where('partner_name', $input['partner_name'])
               ->where('id', '!=', $input['id'])
               ->first();

    if($partner)
    {
      $request->session()->flash('error', 'Partner Name is already exit!');
			return redirect()->back()->withInput();
    }

    $partner = Partner::find($input['id']);
    $partner->partner_name = $input['partner_name'];

    $result = $partner->save();

    //delete first before saving
		PartnerCountry::where('partner_id', $input['id'])->delete();

    for($i = 0; $i < count($input['country_id']); $i++)
    {
      $data = [
        "partner_id" => $input['id'],
        "country_id" => $input['country_id'][$i]
      ];

      PartnerCountry::create($data);
    }

		$request->session()->flash('success', 'Partner Name is successfully updated!');
		return redirect()->back();
  }

  // Selected partners
  public function DeletePartners(Request $request)
  {
    $input = array_except($request->all(), '_token');

    // Delete PartnerCountry Table
		PartnerCountry::where('partner_id', $input['id'])->delete();

    for($i = 0; $i < count($input['id']); $i++)
    {
      $partner = Partner::find($input['id'][$i]);
      $partner->delete();
    }

    $request->session()->flash('success', 'Selected Partners have been deleted!');
    return redirect()->back();
  }

  // Delete Partner
  public function getDeletePartner(Request $request, $id)
  {
    $partner = Partner::find($id);

    if (!$partner) {
      $request->session()->flash('error', 'Selected Partner is not found.');
      return redirect()->back();
  	}

    // Delete PartnerCountry Table
		PartnerCountry::where('partner_id', $id)->delete();

    $partner->delete();

		$request->session()->flash('success', 'Selected Partner has been deleted.');
    return redirect()->back();
  }
}
