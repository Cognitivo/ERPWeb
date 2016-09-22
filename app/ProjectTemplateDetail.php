<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTemplateDetail extends Model
{
    public $primaryKey='id_template_detail';
    protected $table='project_template_detail';   
    public $timestamps = false;


    public function Item()
    {
    	 return $this->belongsTo('App\Items','id_item');
    }
}
