<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionLine extends Model
{
    	public $primaryKey='id_production_line';
    protected $table='production_line';   
    public $timestamps = false;}
