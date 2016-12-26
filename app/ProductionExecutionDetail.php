<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionExecutionDetail extends Model
{
     public $primaryKey = 'id_execution_detail';
    protected $table   = 'production_execution_detail';
    public $timestamps = false;


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

    /**
     * ProductionExecutionDetail belongs to ProductionOrderDeta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productionOrderDetail()
    {
    	// belongsTo(RelatedModel, foreignKey = productionOrderDeta_id, keyOnRelatedModel = id)
    	return $this->belongsTo(ProductionOrderDetail::class,'id_order_detail');
    }
}
