<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table='contacts';
    //protected $fillable=['id_contact','timestamp','name', 'gov_code'];
    public $timestamps = false;
}
