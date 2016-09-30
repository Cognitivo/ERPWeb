<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model
{
    public $primaryKey='id_order_detail,name';
    protected $table='production_order_detail';
    public $timestamps = false;
}
