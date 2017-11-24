<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleStore extends Model
{
  protected $table = 'schedule_store';

  protected $fillable = [
    'store_id',
    'country_id',
    'schedule_id'
  ];
}
