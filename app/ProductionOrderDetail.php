<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model
{
    public $primaryKey = 'id_order_detail';

    protected $table    = 'production_order_detail';
    public $timestamps  = false;
    protected $fillable = ['quantity', 'start_date_est', 'end_date_est'];

    public function getStartDateEstAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y H:i:s');
        }

    }

    public function setStartDateEstAttribute($value)
    {
        if (!is_object($value)) {
            $this->attributes['start_date_est'] = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        } else {
            $this->attributes['start_date_est'] = $value;
        }

    }

    public function setEndDateEstAttribute($value)
    {
        if (!is_object($value)) {
            $this->attributes['end_date_est'] = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        } else {
            $this->attributes['end_date_est'] = $value;
        }

    }

    public function getEndDateEstAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y H:i:s');
        }

    }

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
    public function ProductionExecutionDetail()
    {
        return $this->hasOne('App\ProductionExecutionDetail', 'id_order_detail', 'id_order_detail');

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
            ->leftJoin('production_execution_detail', 'production_execution_detail.id_order_detail', '=', 'production_order_detail.id_order_detail')
            ->where('production_order_detail.id_production_order', $id_order)->orderBy('parent_id_order_detail')
            ->select('production_order_detail.*', 'items.id_item_type', \DB::raw('ifnull(production_execution_detail.quantity,0) as quantity_excution'));

    }

    /**
     * Query scope getProductionOrderDetail.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApiGetProductionOrderDetail($query, $id_order)
    {

        return $query->join('items', 'items.id_item', '=', 'production_order_detail.id_item')

            ->Join(\DB::raw("(SELECT  t1.id_execution_detail,t1.quantity,id_order_detail,
                                        ifnull((select sum(t2.quantity) as q_real
                                        from production_execution_detail as t2
                                        where
                                        t2.parent_id_execution_detail is not null
                                        and t1.id_execution_detail = t2.parent_id_execution_detail),0) as quantity_real
                                        FROM astillero.production_execution_detail as t1

                                        where t1.parent_id_execution_detail is null) as production_execution_detail"),
                'production_execution_detail.id_order_detail', '=', 'production_order_detail.id_order_detail')

            ->where('production_order_detail.id_production_order', $id_order)->where('production_order_detail.status',2)

            ->select('production_execution_detail.id_execution_detail as id', 'production_order_detail.id_production_order', 'production_order_detail.name', \DB::raw('ifnull(cast(production_execution_detail.quantity as unsigned),0) as quantity'), \DB::raw('ifnull(cast(production_execution_detail.quantity_real as unsigned),0) as quantity_real'));
    }
}
