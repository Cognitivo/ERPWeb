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
    public function productionOrderDdetail()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = productionOrder_id, localKey = id)
        return $this->hasMany(ProductionOrderDdetail::class, 'id_production_order');
    }
}
