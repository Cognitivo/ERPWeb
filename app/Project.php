<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     public $primaryKey='id_project';
    protected $table='projects';   
    public $timestamps = false;


    /**
 * Project belongs to Contact.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function contact()
{
	// belongsTo(RelatedModel, foreignKey = contact_id, keyOnRelatedModel = id)
	return $this->belongsTo(Contact::class,'id_contact');
}
}


