<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class ContactTag extends Model
{
       	public $primaryKey='id_tag_detail';
        protected $table='contact_tag_detail';
        protected $fillable=['id_contact_tag_detail','id_tag'];
        public $timestamps = false;
        public function Tag()
        {
            return $this->belongsTo('App\Tag', 'id_tag');
        }

}
