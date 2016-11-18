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


 /**
  * Query scope TotalProductionOrder.
  *
  * @param  \Illuminate\Database\Eloquent\Builder
  * @return \Illuminate\Database\Eloquent\Builder
  */
 public function scopeTotalProductionOrder($query,$id_production_order)
 {

   $result = $query
   ->join('items','items.id_item','=','production_order_detail.id_item')
   
   ->where('id_production_order',$id_production_order)->select(\DB::raw('sum(quantity*unit_cost) as total_production_order'))
   ->first();

   return $result->total_production_order;
 }


 /**
  * Query scope StatusDetail.
  *
  * @param  \Illuminate\Database\Eloquent\Builder
  * @return \Illuminate\Database\Eloquent\Builder
  */
 public function scopeStatusDetail($query,$id_production_order)
 {
   return $query->where('id_production_order',$id_production_order)->where('status',1)->get();
   
 }
}
