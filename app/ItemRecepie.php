<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRecepie extends Model
{
	public $primaryKey='id_recepie';
    protected $table='item_recepie';
    protected $fillable=['timestamp','item_id_item'];
    public $timestamps = false;
}
