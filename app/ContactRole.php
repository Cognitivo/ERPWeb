<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactRole extends Model
{
	public $primaryKey='id_contact_role';
    protected $table='contact_role';
    protected $fillable=['timestamp','name', 'id_contact_role'];
    public $timestamps = false;
}
