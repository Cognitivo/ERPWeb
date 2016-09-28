<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    	public $primaryKey='id_production_order';
    protected $table='production_order';
    public $timestamps = false;

     protected $fillable=['timestamp','name'];
}
