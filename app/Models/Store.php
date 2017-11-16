<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
  protected $table = 'store';

  protected $fillable = [
    'store_name',
    'partner_id',
    'country_id',
    'description',
    'contact_name',
    'contact_no'
  ];
}
