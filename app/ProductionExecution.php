<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionExecution extends Model
{
    public $primaryKey = 'id_production_execution';
    protected $table   = 'production_execution';
    public $timestamps = false;

}
