<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
     public $primaryKey='id_project_task';
    protected $table='project_task';   
    public $timestamps = false;
}
