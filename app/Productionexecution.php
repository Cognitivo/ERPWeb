<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productionexecution extends Model
{
    	public $primaryKey='id_production_execustion';
    protected $table='production_execustion';
    public $timestamps = false;

     protected $fillable=['timestamp','name'];
}
