<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactField extends Model
{
    public $primaryKey = 'id_contact_field';

    protected $table = 'contact_field_value';

    
    public $timestamps = false;

    public function field(){
    	return $this->belongsTo('App\Field','id_field');
    }

    public function scopeget_field_value($query,$id_contact)
    {

    	$result= $query->where('id_contact',$id_contact)->select('value');
         
         
        return $result;
    }
}
