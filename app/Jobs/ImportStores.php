<?php

namespace App\Jobs;

use App\Models\Store;
use App\Models\Country;
use App\Models\Partner;
use App\Models\PartnerCountry;
use DB;
use Illuminate\Http\Request;

class ImportStores extends Job
{
  /**
  * Create a new job instance.
  *
  * @return void
  */
  public function __construct( Request $request )
  {
    $this->request = $request;
  }

  /**
  * Execute the job.
  *
  * @return void
  */
  public function handle()
  {
    $cnt = new \StdClass;
    $cnt->new = 0;
    $cnt->all = 0;
    $cnt->error = 0;
    $cnt->arr = array();
    // $cnt->arr1 = array();

    \Excel::load( $this->request->file( 'file' ), function ( $reader ) use ( $cnt) {
      $data = $reader->get();

      foreach ($data as $d)
      {
        $cnt->error++;

        $country = Country::where('country_name', trim($d->country_name))->first();
        $partner = Partner::where('partner_name', trim($d->partner_name))->first();

        if(!$country || !$partner)
        {
          array_push($cnt->arr, $cnt->error);
        }

        else
        {
          $partner_country = PartnerCountry::where('partner_id', $partner->id)
                             ->where('country_id', $country->id)
                             ->first();

          $list = [
            "store_name" => $d->store_name,
            "country_id" => $country->id,
            "partner_id" => $partner->id,
            "description" => $d->description,
            "contact_name" => $d->contact_name,
            "contact_no" => $d->contact_no
          ];

          Store::create($list);

          $cnt->all++;
        }
      }
    });

    return $cnt;
  }
}
