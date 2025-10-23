<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRemind extends Model
{
    //
    protected $primaryKey = 'user_remind_id';
    protected $fillable = ['user_email', 'user_keyword', 'user_geoId'];
}
