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
