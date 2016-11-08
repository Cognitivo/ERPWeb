<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionExecutionDetail extends Model
{
     public $primaryKey = 'id_execution_detail';
    protected $table   = 'production_execution_detail';
    public $timestamps = false;
}
