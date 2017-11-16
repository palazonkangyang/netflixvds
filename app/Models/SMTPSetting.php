<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMTPSetting extends Model
{
  protected $table = 'smtp_setting';

  protected $fillable = [
    'host',
    'username',
    'password',
    'port',
    'require_ssl'
  ];
}
