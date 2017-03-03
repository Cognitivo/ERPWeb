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

       /**
     * ProjectTemplateDetail has many Projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = projectTemplateDetail_id, localKey = id)
    	return $this->hasMany(Project::class,'id_project_template');
    }
}
