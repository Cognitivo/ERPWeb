<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $primaryKey = 'id_contact';

    protected $table = 'contacts';

    protected $fillable = ['timestamp', 'name', 'gov_code', 'parent_id_contact'];

    public $timestamps = false;

    public function ContactRole()
    {
        return $this->belongsTo('App\ContactRole', 'id_contact_role');
    }


    public function scopelast_contact($query){
        $result=\DB::select('SELECT max(cast(code as unsigned)) as code FROM contacts');
        return $result;
    }

    public function field_value()
    {
    	return $this->hasMany('App\ContactField','id_contact_field');
    }
}
