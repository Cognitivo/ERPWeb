<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    public $primaryKey = 'id_production_order';
    protected $table   = 'production_order';
    public $timestamps = false;

    protected $fillable = ['timestamp', 'name'];

    /**
     * ProductionOrder belongs to .
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        // belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
        return $this->belongsTo(Project::class, 'id_project');
    }

    /**
     * ProductionOrder has many ProductionOrderDdetail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productionOrderDetail()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = productionOrder_id, localKey = id)
        return $this->hasMany(ProductionOrderDetail::class, 'id_production_order');
    }

      public function productionLine()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = productionOrder_id, localKey = id)
        return $this->belongsTo(ProductionLine::class, 'id_production_line');
    }

     /**
     * Get all of the production execution detail.
     */
    public function productionExecutions()
    {
        return $this->hasManyThrough('App\ProductionExecutionDetail', 'App\ProductionOrderDetail','id_production_order','id_order_detail','id_execution_detail');
    }
}
