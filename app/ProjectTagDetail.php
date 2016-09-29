<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTagDetail extends Model
{
    public $primaryKey='id_project_tag_detail';
    protected $table='project_tag_detail';   
    public $timestamps = false;
}
