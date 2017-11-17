<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerCountry extends Model
{
  protected $table = 'partner_country';

  protected $fillable = [
    'partner_id',
    'country_id'
  ];
}
