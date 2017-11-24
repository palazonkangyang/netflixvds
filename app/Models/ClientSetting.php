<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSetting extends Model
{
  protected $table = 'client_setting';

  protected $fillable = [
    'client_key',
    'time_zone',
    'auto_update',
    'user_id'
  ];
}
