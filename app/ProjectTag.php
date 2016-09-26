<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model
{
    public $primaryKey='id_tag';
    protected $table='project_tag';   
    public $timestamps = false;


    public function details(){
    	 return $this->hasMany('App\ProjectTagDetail','id_tag');
    }
}
