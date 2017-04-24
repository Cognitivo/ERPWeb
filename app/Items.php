<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
	public $primaryKey='id_item';
    protected $table='items';
    protected $fillable=['timestamp','name', 'code'];
    public $timestamps = false;

    public static function typeItem($id_item)
    {
    	$obj_item = new static;
    	$item = $obj_item->find($id_item);
    	if($item){
    		return $item->id_item_type;
    	}
    	return null;
    }
}
