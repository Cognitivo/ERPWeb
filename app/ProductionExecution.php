<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionExecution extends Model
{
    public $primaryKey = 'id_production_execution';
    protected $table   = 'production_execution';
    public $timestamps = false;


    /**
     * ProductionExecution has many Detail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail()
    {
    	// hasMany(RelatedModel, foreignKeyOnRelatedModel = productionExecution_id, localKey = id)
    	return $this->hasMany(ProductionExecutionDetail::class,'id_production_execution');
    }

    /**
     * ProductionExecution belongs to ProductionOrder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productionOrder()
    {
    	// belongsTo(RelatedModel, foreignKey = productionOrder_id, keyOnRelatedModel = id)
    	return $this->belongsTo(ProductionOrder::class,'id_production_order');
    }

}
