<?php

namespace App\Http\Controllers\Garments;

use App\Http\Controllers\Controller;
use App\Items;
use App\ProductionOrder;
use App\ProductionOrderDetail;
use App\ProductionLine;
use App\ItemRecepie;
use App\ItemRecepieDetail;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productions=ProductionOrder::get();

        return view('garments/production',compact('productions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filterJson=array();
        $File=storage_path() . "/json/curve.json";
        $Json= json_decode(file_get_contents($File),true);
        $item=Items::select('id_item','name')->get();
        $lines= ProductionLine::select('name', 'id_production_line')->get();
      //  dd($Json);
        return view('garments/productionform',compact('Json','item','filterJson','lines'));
    }
    public function fetch(Request $request)
    {
    //  dd($request);
       $id_curve=$request->id_curve;
        $File=storage_path() . "/json/curve.json";
        $Json= json_decode(file_get_contents($File),true);
        $filterJson=array();
        foreach ($Json as $key => $value) {

            if ($value['name']==$id_curve)
            {
                $filterJson=$value['size'] ;
            }

        }

        $item=Items::select('id_item','name')->get();
        $lines= ProductionLine::select('name', 'id_production_line')->get();
      //  dd($Json);
        return view('garments/productionform',compact('Json','item','id_curve','filterJson','lines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $range_date = explode("-", $request->range_date);
       $item=Items::where('id_item',$request->id_item)->first();
        $production_order                     = new ProductionOrder;
        $production_order->id_production_line = $request->id_production_line;
    //    $production_order->id_project         = 1;
        $production_order->name               = 'Produccion del ' . Carbon::now();
        $production_order->trans_date         = Carbon::now();
        $production_order->id_company         =  Auth::user()->id_company;
        $production_order->id_branch          = 1;
        $production_order->id_terminal        = 1;
        $production_order->id_user            =  Auth::user()->id_user;
        $production_order->is_head            = 1;
        $production_order->timestamp          = Carbon::now();
        $production_order->start_date_est     = Controller::convertDate($range_date[0]);
        $production_order->end_date_est       = Controller::convertDate($range_date[1]);
        $production_order->is_head            = 1;
        $production_order->is_read            = 0;
        $production_order->status             = 1;

        $production_order->save();
        for($i=0;$i<count($request->name);$i++){

        $production_order_detail                         = new ProductionOrderDetail;
        $production_order_detail->id_production_order    = $production_order->getKey();
        $production_order_detail->name                   = $item->name . ' ' . '[' . $request->name[$i] . ']';
        $production_order_detail->quantity               = $request->quantity[$i];
        $production_order_detail->id_item                = $request->id_item;
        $production_order_detail->id_company             = 1;
        $production_order_detail->id_user                = 1;
        $production_order_detail->is_input               = 0;
        $production_order_detail->is_head                = 1;
        $production_order_detail->is_read                = 0;
        $production_order_detail->status                 = 1;
        $production_order_detail->timestamp              = Carbon::now();
        $production_order_detail->trans_date             = Carbon::now();
        $production_order->start_date_est     = Controller::convertDate($range_date[0]);
        $production_order->end_date_est       = Controller::convertDate($range_date[1]);
        $production_order_detail->save();
        $recepie=ItemRecepie::where('item_id_item',$request->id_item)->first();
        if (isset($recepie)) {
              $recepiedetails=ItemRecepieDetail::where('item_recepie_id_recepie',$recepie->id_recepie)->get();
              foreach ($recepiedetails as $recepiedetail) {
                $detailitem=Items::where('id_item',$recepiedetail->item_id_item)->first();
                if (isset($detailitem)) {
                  $production_order_detailchild                         = new ProductionOrderDetail;
                  $production_order_detailchild->id_production_order    = $production_order->getKey();
                  $production_order_detailchild->name                   = $detailitem->name . ' ' . '[' . $request->name[$i] . ']';
                  $production_order_detailchild->quantity               = $production_order_detail->quantity * $recepiedetail->quantity;
                  $production_order_detailchild->id_item                = $detailitem->id_item;
                  $production_order_detailchild->id_company             = 1;
                  $production_order_detailchild->id_user                = 1;
                  $production_order_detailchild->is_input               = 1;
                  $production_order_detailchild->is_head                = 1;
                  $production_order_detailchild->is_read                = 0;
                  $production_order_detailchild->parent_id_order_detail  = $production_order_detail->id_order_detail;
                  $production_order_detailchild->status                 = 1;
                  $production_order_detailchild->timestamp              = Carbon::now();
                  $production_order_detailchild->trans_date             = Carbon::now();
                  $production_order_detailchild->start_date_est     = Controller::convertDate($range_date[0]);
                  $production_order_detailchild->end_date_est       = Controller::convertDate($range_date[1]);
                  $production_order_detailchild->save();
                }

              }
        }
    }
    $productions=ProductionOrder::get();

    return view('garments/production',compact('productions'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
