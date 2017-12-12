<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRecepieDetail extends Model
{
	public $primaryKey='id_recepie_detail';
    protected $table='item_recepie_detail';
    protected $fillable=['timestamp','quantity'];
    public $timestamps = false;
}
