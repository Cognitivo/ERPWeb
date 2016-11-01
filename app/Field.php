<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public $primaryKey = 'id_field';

    protected $table = 'app_field';
    public $timestamps = false;
}
