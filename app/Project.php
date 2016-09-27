<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     public $primaryKey='id_project';
    protected $table='projects';   
    public $timestamps = false;
}
