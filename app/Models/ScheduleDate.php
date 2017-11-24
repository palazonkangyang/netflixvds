<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
  protected $table = 'schedule_date';

  protected $fillable = [
    'from_date',
    'to_date',
    'time_zone_id',
    'schedule_id'
  ];
}
