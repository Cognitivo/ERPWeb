<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	public $primaryKey='id_contact';
    protected $table='contacts';
    protected $fillable=['timestamp','name', 'gov_code','parent_id_contact'];
    public $timestamps = false;


		        public function ContactRole()
		        {
		            return $this->belongsTo('App\ContactRole', 'id_contact_role');
		        }
}
