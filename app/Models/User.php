<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $table = 'users';

  protected $fillable = [
    'username',
    'password',
    'full_name',
    'email',
    'role',
    'client_key',
    'partner_id',
    'country_id',
    'store_id'
  ];
}
