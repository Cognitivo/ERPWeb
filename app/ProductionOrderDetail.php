<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model
{
    public $primaryKey = 'id_order_detail';
    protected $table   = 'production_order_detail';
    public $timestamps = false;

    /**
     * ProductionOrderDetail belongs to ProductionOrder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productionOrder()
    {
        // belongsTo(RelatedModel, foreignKey = productionOrder_id, keyOnRelatedModel = id)
        return $this->belongsTo(ProductionOrder::class, 'id_production_order');
    }

    /**
     * ProductionExecutionDetail belongs to Item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        // belongsTo(RelatedModel, foreignKey = item_id, keyOnRelatedModel = id)
        return $this->belongsTo(Items::class, 'id_item');
    }

    /**
     * Query scope TotalProductionOrder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTotalProductionOrder($query, $id_production_order)
    {

        $result = $query
            ->join('items', 'items.id_item', '=', 'production_order_detail.id_item')

            ->where('id_production_order', $id_production_order)->select(\DB::raw('sum(quantity*unit_cost) as total_production_order'))
            ->first();

        return $result->total_production_order;
    }

    /**
     * Query scope StatusDetail.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatusDetail($query, $id_production_order)
    {
        return $query->where('id_production_order', $id_production_order)->where('status', 1)->get();

    }

    /**
     * Query scope getProductionOrderDetail.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetProductionOrderDetail($query, $id_order)
    {
        
        return $query->join('items', 'items.id_item', '=', 'production_order_detail.id_item')

            ->leftJoin('production_execution', 'production_execution.id_production_order', '=', 'production_order_detail.id_production_order')

            ->leftJoin('production_execution_detail', 'production_execution_detail.id_order_detail', '=', 'production_order_detail.id_order_detail')

            ->where('production_order_detail.id_production_order', $id_order)

            ->where('id_item_type', '!=', '5')

            ->select('production_order_detail.*', 'items.id_item_type', \DB::raw('ifnull(production_execution_detail.quantity,0) as quantity_excution'), 'production_execution.id_production_execution');
    }
}
