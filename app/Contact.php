<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{   
	public $primaryKey='id_contact';

    protected $table='contacts';

    protected $fillable=['timestamp','name', 'gov_code'];
    
    public $timestamps = false;
}
