<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public $primaryKey='id_contract';
        protected $table='app_contract';
        
        public $timestamps = false;
}
