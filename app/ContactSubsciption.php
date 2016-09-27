<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContactSubsciption extends Model
{
         public $timestamps = false;
       	public $primaryKey='id_subscription';
        protected $table='contact_subscription';
        protected $fillable=[ 'timestamp','start_date','end_date','unit_price'];
       

        public function Items()
        {
            return $this->belongsTo('App\Items', 'id_item');
        }

        public function Contacts(){
        	return $this->belongsTo('App\Contact','id_contact');
        }
}
