<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppLocation extends Model
{
    public $primaryKey = 'id_location';

    protected $table = 'app_location';
}
