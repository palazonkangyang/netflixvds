<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  protected $table = 'video';

  protected $fillable = [
    'date',
    'code',
    'title',
    'video_name',
    'thumbnail_name',
    'description',
    'duration',
    'category_id'
  ];
}
