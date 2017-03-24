<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\ProductionExecution;
use App\ProductionExecutionDetail;
use App\ProductionOrder;
use App\ProductionOrderDetail;
use App\Item;
use App\Item_Product;
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
        $execution = ProductionOrder::whereIn('status',[2,4])->get();
      
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


        $production_order = ProductionOrder::find($request->id_production_order);


            //return response()->json($request->all());


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

                $production_execution_detail->id_item = $request->id_item;

                $production_execution_detail->save();

            }

            return response()->json($production_execution->getKey());

        } else {

            //insert

            $production_execution = new ProductionExecution;



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

            $production_execution_detail->id_item = $request->id_item;

            $production_execution_detail->save();

              /*$production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($production_order->id_production_order)->get();*/

            return response()->json($production_execution->getKey());

        }


    }

    public function approveExcecution($id)
    {

        $production_execution = ProductionExecution::find($id);

        if($production_execution != null){

            $production_execution->status = 2;

            $production_execution->save();

            $production_order = ProductionOrder::find($production_execution->getKey());

            $production_order->status = 3;

            $production_order->save();

             return response()->json("ok");
        }

       return response()->json("no");
    }
    public function api_approve(Request $request)
    {


          $transactions = [];

          $collect = collect();

          if ($request->Transactions != []) {

              $transactions = $request->Transactions;

              $collect = collect($transactions);

              Log::info($collect->toJson());

          }

          $array_transactions = json_decode($collect->toJson());


                $production_execution_detail = new ProductionExecutionDetail;


                 $production_execution_detail->id_order_detail = $array_transactions->id_order_detail;

                 $production_execution_detail->quantity = $array_transactions->quantity_excution;

                 $production_execution_detail->start_date = $array_transactions->start_date_est;

                 $production_execution_detail->end_date = $array_transactions->end_date_est;

                 $production_execution_detail->unit_cost = 0;

                 $production_execution_detail->is_input = $array_transactions->is_input;

                 $production_execution_detail->trans_date = Carbon::now();

                 $production_execution_detail->timestamp = Carbon::now();

                 $production_execution_detail->id_company = 1;

                 $production_execution_detail->id_user = 1;

                 $production_execution_detail->is_head = 1;

                 $production_execution_detail->is_read = 1;

                 $production_execution_detail->id_item = $array_transactions->id_item;

                 $production_execution_detail->save();

                $item=Item::where('id_item','=',$array_transactions->id_item)->first();
                if (isset($item)) {
                    if ($item->id_item_type==1 || $item->id_item_type==2 ||  $item->id_item_type==6 )
                    {
                          $item_product=Item_Product::where('id_item','=',$array_transactions->id_item)->first();
                          $orderdetail=ProductionOrderDetail::where('id_order_detail','=',$array_transactions->id_order_detail)->first();
                          $order=ProductionOrder::where('id_production_order','=',$orderdetail->id_order_detail)->first();
                          $line=productionLine::where('id_production_line','=',$order->id_production_line)->first();
                          if (isset($item_product)) {
                            if ($array_transactions->is_input) {
                              if ($array_transactions->quantity_excution>0) {
                                $sql ='select
                                  loc.id_location as LocationID,
                                  loc.name as Location,
                                  parent.id_movement as MovementID,
                                  parent.trans_date as TransDate, parent.expire_date,parent.code,
                                  parent.credit - if( sum(child.debit) > 0, sum(child.debit), 0 ) as QtyBalance,
                                  (select sum(unit_value) from item_movement_value as parent_val where id_movement = parent.id_movement) as Cost

                                  from item_movement as parent
                                  inner join app_location as loc on parent.id_location = loc.id_location
                                  left join item_movement as child on child.parent_id_movement = parent.id_movement

                                  where parent.id_location='.strval($line->id_location).' and parent.id_item_product = '.strval($item_product->id_item_product).' and parent.status = 2 and parent.debit = 0
                                  group by parent.id_movement
                                  order by parent.trans_date';
                                // $instocklist=  DB::select($sql);
                                $item_movement = new ItemMovement;
                                $item_movement->comment = Comment;
                                $item_movement->id_item_product = $item_product->id_item_product;
                                $item_movement->debit = $array_transactions->quantity_excution;
                                $item_movement->credit = 0;
                                $item_movement->status = 3;
                                //Check for Better Code.
                                $item_movement->id_location = $line->id_location;
                                $item_movement->save();
                              }
                            }

                          }
                    }
                }


              return response()->json(['message' => 'transactions ok']);

    }
}
