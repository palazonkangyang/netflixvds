<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Store;
use App\Models\Partner;
use App\Models\Country;
use App\Models\PartnerCountry;
use App\Jobs\ImportStores;
use Auth;
use DB;
use Hash;
use Mail;
use Input;
use Session;
use View;
use URL;
use Carbon\Carbon;

class StoreController extends Controller
{
  // Get Stores
  public function index()
  {
    $partners = Partner::orderBy('id', 'asc')->get();

    $stores = Store::leftjoin('country', 'store.country_id', '=', 'country.id')
              ->leftjoin('partner', 'store.partner_id', '=', 'partner.id')
              ->select('store.*', 'country.country_name', 'partner.partner_name')
              ->orderBy('partner.partner_name', 'asc')
              ->orderBy('store.store_name', 'asc')
              ->paginate(10);

    return view('stores.index', [
      "partners" => $partners,
      "stores" => $stores
    ]);
  }

  // Search Stores
  public function SearchStores(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $store_name= "";
    $country_id = "";
    $partner_id = "";
    $countries = [];

    $partners = Partner::orderBy('id', 'asc')->get();

    $q = Store::query();

    if(isset($input['store_name']))
    {
      $store_name = trim($input['store_name']);

      $q->where('store.store_name', 'like', '%' . $store_name . '%');
    }

    if(isset($input['country_id']))
    {
      $country_id = $input['country_id'];

      if($input['country_id'] != 0)
      {
        $q->where('store.country_id', '=', $input['country_id']);
      }
    }

    if(isset($input['partner_id']))
    {
      $partner_id = $input['partner_id'];

      if($input['partner_id'] != 0)
      {
        $q->where('store.partner_id', '=', $input['partner_id']);

        $countries = PartnerCountry::leftjoin('country', 'partner_country.country_id', '=', 'country.id')
                     ->where('partner_country.partner_id', $input['partner_id'])
                     ->orderBy('country.id', 'asc')
                     ->get();
      }
    }

    $stores = $q->leftjoin('country', 'store.country_id', 'country.id')
              ->leftjoin('partner', 'store.partner_id', 'partner.id')
              ->select('store.*', 'country.country_name', 'partner.partner_name')
              ->orderBy('partner.partner_name', 'asc')
              ->orderBy('store.store_name', 'asc')
              ->paginate(10);

    return view('stores.search-stores', [
      'partners' => $partners,
      'countries' => $countries,
      'stores' => $stores,
      'partner_id' => $partner_id,
      'country_id' => $country_id,
      'keyword' => $store_name
    ]);
  }

  // Get New Store
  public function getNewStore()
  {
    $partners = Partner::orderBy('id', 'asc')->get();

    return view('stores.new-store', [
      "partners" => $partners
    ]);
  }

  // Add New Store
  public function postNewStore(Request $request)
  {
    $input = array_except($request->all(), '_token');

    $store = Store::where('store_name', $input['store_name'])
             ->where('partner_id', $input['partner_id'])
             ->where('country_id', $input['country_id'])
             ->first();

    if($store)
    {
      $request->session()->flash('error', 'Store Name is already exit!');
			return redirect()->back()->withInput();
    }

    Store::create($input);

    $request->session()->flash('success', 'New Store has been successfully created!');
		return redirect()->back();
  }

  // Get Edit Store
  public function getEditStore(Request $request, $id)
  {
    $partners = Partner::orderBy('id', 'asc')->get();
    $store = Store::find($id);

    $countries = Country::leftjoin('partner_country', 'country.id', 'partner_country.country_id')
                 ->where('partner_country.partner_id', $store->partner_id)
                 ->select('country.id', 'country.country_name')
                 ->get();

    return view('stores.edit-store', [
      'partners' => $partners,
      'countries' => $countries,
      'store' => $store
    ]);
  }

  // Update Store
  public function postEditStore(Request $request, $id)
  {
    $input = array_except($request->all(), '_token');

    $store = Store::where('partner_id', $input['partner_id'])
             ->where('country_id', $input['country_id'])
             ->where('store_name', $input['store_name'])
             ->where('id', '!=', $input['id'])
             ->first();

    if($store)
    {
      $request->session()->flash('error', 'Store Name is already exit!');
			return redirect()->back()->withInput();
    }

    $store = Store::find($input['id']);
    $store->partner_id = $input['partner_id'];
    $store->country_id = $input['country_id'];
    $store->store_name = $input['store_name'];
    $store->description = $input['description'];
    $store->contact_name = $input['contact_name'];
    $store->contact_no = $input['contact_no'];
    $store->save();

    $request->session()->flash('success', 'Store Name is successfully updated!');
		return redirect()->back();
  }

  // Get Import
  public function getImport()
  {
    return view('stores.import');
  }

  // Post Import
  public function postImport(Request $request, ImportStores $import)
  {
    $input = array_except($request->all(), '_token');

    $cnt = $import->handle();

    if ( $cnt === false )
    {
      $request->session()->flash('error', 'Bad input file');
      return back();
    }

    if($cnt->arr)
    {
      $request->session()->flash('success', 'Please check the respective countries and partners in the following lines: ' . implode(', ', $cnt->arr) . '.');
    }

    elseif($cnt->arr1)
    {
      $request->session()->flash('success', 'Please check duplicate store names in the following lines: ' . implode(', ', $cnt->arr1) . '.');
    }

    else
    {
      $request->session()->flash('success', 'Processed Stores:' . $cnt->all);
    }

    return redirect(route('stores-page'));
  }

  // Delete Stores
  public function DeleteStores(Request $request)
  {
    $input = array_except($request->all(), '_token');

    for($i = 0; $i < count($input['id']); $i++)
    {
      $store = Store::find($input['id'][$i]);
      $store->delete();
    }

    $request->session()->flash('success', 'Selected Stores have been deleted!');
    return redirect()->back();
  }

  // Delete Store
  public function getDeleteStore(Request $request, $id)
  {
    $store = Store::find($id);

    if (!$store) {
      $request->session()->flash('error', 'Selected Store is not found!');
      return redirect()->back();
  	}

    $store->delete();

		$request->session()->flash('success', 'Selected Store has been deleted!');
    return redirect()->back();
  }
}
