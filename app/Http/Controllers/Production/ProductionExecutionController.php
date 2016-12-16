<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\ProductionExecution;
use App\ProductionExecutionDetail;
use App\ProductionOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductionExecutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $execution = ProductionExecution::all();

        //dd($execution[0]->detail()->get());
        return view('Production/list_production_execution', compact('execution'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //Api Methods

    public function saveUpdate(Request $request)
    {
        //return response()->json($request->all());

        $production_order = ProductionOrder::find($request->id_production_order);

        if ($request->id_production_execution != null) {

            //update
            $production_execution = ProductionExecution::find($request->id_production_execution);

            $production_execution->timestamp = Carbon::now();

            $production_execution->save();

            $production_execution_detail = ProductionExecutionDetail::where('id_order_detail', $request->id_order_detail);

            if ($production_execution_detail->get()->count()) {

                $production_execution_detail->update(

                    ['quantity' => $request->quantity_excution,

                        'timestamp' => Carbon::now()]);

            } else {

                 $production_execution_detail = new ProductionExecutionDetail;

                $production_execution_detail->id_production_execution = $production_execution->getKey();

                $production_execution_detail->id_order_detail = $request->id_order_detail;

                $production_execution_detail->quantity = $request->quantity_excution;

                $production_execution_detail->start_date = $production_order->start_date_est;

                $production_execution_detail->end_date = $production_order->end_date_est;

                $production_execution_detail->unit_cost = 0;

                $production_execution_detail->is_input = 1;

                $production_execution_detail->trans_date = Carbon::now();

                $production_execution_detail->timestamp = Carbon::now();

                $production_execution_detail->id_company = 1;

                $production_execution_detail->id_user = 1;

                $production_execution_detail->is_head = 1;

                $production_execution_detail->is_read = 1;

                $production_execution_detail->save();

            }

            return response()->json("ok");
        } else {

            //insert

            $production_execution = new ProductionExecution;

            $production_execution_detail = new ProductionExecutionDetail;

            $production_execution->id_production_order = $request->id_production_order;

            $production_execution->id_production_line = $production_order->productionLine->id_production_line;

            $production_execution->trans_date = Carbon::now();

            $production_execution->status = 1;

            $production_execution->id_company = 1;

            $production_execution->id_user = 1;

            $production_execution->is_head = 1;

            $production_execution->timestamp = Carbon::now();

            $production_execution->is_read = 1;

            $production_execution->save();

            $production_execution_detail->id_production_execution = $production_execution->getKey();

            $production_execution_detail->id_order_detail = $request->id_order_detail;

            $production_execution_detail->quantity = $request->quantity_excution;

            $production_execution_detail->start_date = $production_order->start_date_est;

            $production_execution_detail->end_date = $production_order->end_date_est;

            $production_execution_detail->unit_cost = 0;

            $production_execution_detail->is_input = 1;

            $production_execution_detail->trans_date = Carbon::now();

            $production_execution_detail->timestamp = Carbon::now();

            $production_execution_detail->id_company = 1;

            $production_execution_detail->id_user = 1;

            $production_execution_detail->is_head = 1;

            $production_execution_detail->is_read = 1;

            $production_execution_detail->save();

        }

        return response()->json(true);
    }
}
