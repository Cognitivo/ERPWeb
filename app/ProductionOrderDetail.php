<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model
{
    public $primaryKey='id_order_detail';
    protected $table='production_order_detail';
    public $timestamps = false;



  /**
   * ProductionOrderDetail belongs to ProductionOrder.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function productionOrder()
  {
  	// belongsTo(RelatedModel, foreignKey = productionOrder_id, keyOnRelatedModel = id)
  	return $this->belongsTo(ProductionOrder::class,'id_production_order');
  }
}
