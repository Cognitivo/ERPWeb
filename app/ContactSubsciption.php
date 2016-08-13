<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContactSubsciption extends Model
{
       	public $primaryKey='id_subscription';
        protected $table='contact_subscription';
        protected $fillable=['id_subscription','id_item', 'timestamp','start_date','end_date','unit_price'];
        public $timestamps = false;

        public function Items()
        {
            return $this->belongsTo('App\Items', 'id_item');
        }
}
