<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateMsg extends Model
{
    protected $fillable = ['table_id', 'm_msg', 'f_msg'];
}
