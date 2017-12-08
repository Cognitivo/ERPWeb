<?php

namespace App\Http\Controllers\Garments;

use App\Http\Controllers\Controller;
use App\Items;
use App\ProductionOrder;
use App\ProductionOrderDetail;
use Carbon\Carbon;
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
        $File=storage_path() . "/json/curve.json";
        $Json= json_decode(file_get_contents($File),true);


        return view('garments/curveindex',compact('Json'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $File=storage_path() . "/json/curve.json";
        $Json= json_decode(file_get_contents($File),true);
        $item=Items::select('id_item','name')->get();
        return view('garments/productionform',compact('Json','item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $item=Items::where('id_item',$request->id_item)->first();
        $production_order                     = new ProductionOrder;
        $production_order->id_production_line = 1;
        $production_order->id_project         = 1;
        $production_order->name               = 'abc';
        $production_order->trans_date         = Carbon::now();
        $production_order->id_company         = 1;
        $production_order->id_branch          = 1;
        $production_order->id_terminal        = 1;
        $production_order->id_user            = 1;
        $production_order->is_head            = 1;
        $production_order->timestamp          = Carbon::now();
        $production_order->is_head            = 1;
        $production_order->is_read            = 1;
        $production_order->status             = 1;

        $production_order->save();
        for($i=0;$i<count($request->name);$i++){

        $production_order_detail                         = new ProductionOrderDetail;
        $production_order_detail->id_production_order    = $production_order->getKey();
        $production_order_detail->name                   = $item->name . ' ' . $request->name[$i];
        $production_order_detail->quantity               = $request->quantity[$i];
        $production_order_detail->id_item                = $request->id_item;
        $production_order_detail->id_company             = 1;
        $production_order_detail->id_user                = 1;
        $production_order_detail->is_input               = 1;
        $production_order_detail->is_head                = 1;
        $production_order_detail->is_read                = 1;
        $production_order_detail->status                 = 1;
        $production_order_detail->timestamp              = Carbon::now();
        $production_order_detail->trans_date             = Carbon::now();
        $production_order_detail->start_date_est         = Carbon::now();
        $production_order_detail->end_date_est           = Carbon::now()->addDay();
        $production_order_detail->save();
    }
    $File=storage_path() . "/json/curve.json";
    $Json= json_decode(file_get_contents($File),true);
    $item=Items::select('id_item','name')->get();
    return view('garments/productionform',compact('Json','item'));

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
