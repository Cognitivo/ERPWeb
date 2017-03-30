<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionExecutionDetail extends Model
{
     public $primaryKey = 'id_execution_detail';
    protected $table   = 'production_execution_detail';
    public $timestamps = false;
  protected $fillable=['quantity'];

    /**
     * ProductionExecutionDetail belongs to Item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
    	// belongsTo(RelatedModel, foreignKey = item_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Items::class,'id_item');
    }

    public function ProductionOrderDetail()
    {
    	// belongsTo(RelatedModel, foreignKey = item_id, keyOnRelatedModel = id)
    	return $this->belongsTo(ProductionOrderDetail::class,'id_order_detail');
    }

    /**
     * ProductionExecutionDetail belongs to ProductionOrderDeta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

}
