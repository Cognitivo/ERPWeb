<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
	public $primaryKey='id_item';
    protected $table='items';
    protected $fillable=['timestamp','name', 'code'];
    public $timestamps = false;
}
