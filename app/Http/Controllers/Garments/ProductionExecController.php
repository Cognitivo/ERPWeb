<?php

namespace App\Http\Controllers\Garments;

use App\Http\Controllers\Controller;
use App\Items;
use App\ProductionOrder;
use App\ProductionOrderDetail;
use App\ProductionExecutionDetail;
use App\ProductionLine;
use App\ItemRecepie;
use App\ItemRecepieDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductionExecController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productions=ProductionOrder::get();

        return view('garments/productionexec',compact('productions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         for($i=0;$i<count($request->detail);$i++){
           $order_detail=ProductionOrderDetail::where('id_order_detail',$request->detail[$i])->first();
           if (isset($order_detail)) {
             $production_execution_detail = new ProductionExecutionDetail;
             //$production_execution_detail->parent_id_execution_detail = $id;
             $production_execution_detail->quantity   = $request->quantity[$i];
             $production_execution_detail->name       = $order_detail->name;
             $production_execution_detail->start_date = Carbon::now();
             $production_execution_detail->end_date   = Carbon::now();
             // $production_execution_detail->unit_cost  = 0;
             $production_execution_detail->is_input        = 0;
             $production_execution_detail->trans_date      = Carbon::now();
             $production_execution_detail->timestamp       = Carbon::now();
             $production_execution_detail->id_company      = 1;
             $production_execution_detail->id_user         = 1;
             $production_execution_detail->is_head         = 1;
             $production_execution_detail->is_read         = 0;
             $production_execution_detail->id_order_detail = $order_detail->id_order_detail;
             $production_execution_detail->id_item         = $order_detail->id_item;
             $production_execution_detail->unit_cost       = 0;
             $production_execution_detail->save();
             $recepie=ItemRecepie::where('item_id_item',$order_detail->id_item)->first();
             if (isset($recepie)) {

                   $childorderdetails=ProductionOrderDetail::where('parent_id_order_detail',$request->detail[$i])->get();
                   foreach ($childorderdetails as $childorderdetail) {

                     $detailitem=Items::where('id_item',$childorderdetail->id_item)->first();
                     if (isset($detailitem)) {
                        $recepiedetail=ItemRecepieDetail::where('item_recepie_id_recepie',$recepie->id_recepie)->where('item_id_item',$detailitem->id_item)->first();
                       $production_execution_detailchild = new ProductionExecutionDetail;
                       //$production_execution_detail->parent_id_execution_detail = $id;
                       $production_execution_detailchild->quantity   = $production_execution_detail->quantity * $recepiedetail->quantity;
                       $production_execution_detailchild->name       = $detailitem->name;
                       $production_execution_detailchild->start_date = Carbon::now();
                       $production_execution_detailchild->end_date   = Carbon::now();
                       // $production_execution_detail->unit_cost  = 0;
                       $production_execution_detailchild->is_input        = 1;
                       $production_execution_detailchild->trans_date      = Carbon::now();
                       $production_execution_detailchild->timestamp       = Carbon::now();
                       $production_execution_detailchild->id_company      = 1;
                       $production_execution_detailchild->id_user         = 1;
                       $production_execution_detailchild->is_head         = 1;
                       $production_execution_detailchild->is_read         = 0;
                        $production_execution_detailchild->parent_id_execution_detail = $production_execution_detail->id_execution_detail;
                       $production_execution_detailchild->id_order_detail = $childorderdetail->id_order_detail;
                       $production_execution_detailchild->id_item         = $childorderdetail->id_item;
                       $production_execution_detailchild->unit_cost       = 0;
                       $production_execution_detailchild->save();
                     }

                   }
             }
           }

       }

       $productions=ProductionOrder::get();

       return view('garments/productionexec',compact('productions'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $details=ProductionOrderDetail::where('id_production_order',$id)->where('parent_id_order_detail',null)->get();
        return view('garments/productionexecform',compact('details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


    }



}
