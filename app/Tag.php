<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
       	public $primaryKey='id_tag';
        protected $table='contact_tag';
        protected $fillable=['id_tag','name'];
        public $timestamps = false;
      

}
