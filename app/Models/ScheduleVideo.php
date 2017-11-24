<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleVideo extends Model
{
  protected $table = 'schedule_video';

  protected $fillable = [
    'video_id',
    'sequence',
    'schedule_id'
  ];
}
