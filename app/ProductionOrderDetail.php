<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model
{
    public $primaryKey='id_order_detail';
    protected $table='production_order_detail';
    public $timestamps = false;
    public function productionLine()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = productionOrder_id, localKey = id)
        return $this->belongsTo(ProductionLine::class, 'id_production_line');
    }
}
