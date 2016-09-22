<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTemplate extends Model
{
    public $primaryKey='id_project_template';
    protected $table='project_template';   
    public $timestamps = false;


    public function details(){
    	 return $this->hasMany('App\ProjectTemplateDetail','id_project_template');
    }
}
