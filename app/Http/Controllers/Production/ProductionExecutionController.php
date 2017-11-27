<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Item;
use App\Item_Product;
use App\ProductionExecution;
use App\ProductionExecutionDetail;
use App\ProductionOrder;
use App\ProductionOrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class ProductionExecutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (\Request::ajax()) {
            return $this->indexData();
        }

        return view('Production/list_production_execution');
    }

    public function indexData()
    {

        $orders = ProductionOrder::leftJoin('production_line', 'production_line.id_production_line', '=', 'production_order.id_production_line')->

            select(['id_production_order', 'work_number', 'production_order.name', 'production_line.name as linea', 'status'])->whereIn('production_order.status', [2, 4])->get();

        return Datatables::of($orders)

            ->addColumn('actions', function ($order) {
                $result = '';

                $result = '<a href="/production_execution/' . $order->id_production_order . '/edit" class="btn btn-sm btn-primary" >
                <i class="glyphicon glyphicon-edit"></i>
                </a>/

                    ';
                    if($order->status != 4){
                        $result = $result . ' <a  style="display: inline;" class="btn-delete btn btn-sm btn-danger"  data-toggle="confirmation" data-original-title="Terminar Execution?" data-placement="top" >
                            <i class="glyphicon glyphicon-ok"></i>
                        </a>';
                    }

                return $result;

            })->editColumn('status', function ($order) {

            $status = $order->productionOrderDetail()->first() != null ? $order->productionOrderDetail()->first()->status : null;
            if ($status == 2) {
                return 'Aprobado';
            } else if ($status == 4) {
                return 'Executado';
            }
        })->addRowAttr('data-id', function ($order) {
            return $order->id_production_order;
        })

            ->removeColumn('id_production_order')
            ->make();
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

        return view('Production/form_execution_detail')->with('id', $id);
    }

    public function productionExecutionTable($id)
    {
        $order_detail = ProductionOrderDetail::GetProductionOrderDetail($id)->get();

        return Datatables::of($order_detail)

            ->addColumn('actions', function ($order) {
                $result = '<a href="#" v-on:click="loadDataExecutionDetail(' . $order->id . ')" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_detail_execution">
                <i class="glyphicon glyphicon-edit"></i>
                </a>';
                return $result;
            })
            ->removeColumn('id')
            ->make();

    }

    public function loadDetail($id)
    {
        # code...
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
        $production_execution_detail           = ProductionExecutionDetail::find($id);
        $production_execution_detail->quantity = $request->quantity;
        $production_execution_detail->save();
        $execution = ProductionOrder::whereIn('status', [2])->get();
        return view('Production/list_production_execution', compact('execution'));
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
    public function ProductionExecutionDetail($id_order_detail)
    {

        $ProductionExecutionDetail = ProductionExecutionDetail::where('id_order_detail', $id_order_detail)
        ->leftJoin('security_user', 'security_user.id_user', '=', 'production_execution_detail.id_user')
        ->select('id_execution_detail as id', 'security_user.name as userName',
        \DB::raw('ifnull(cast(production_execution_detail.quantity as unsigned),0) as quantity'), 'unit_cost as unitCost','production_execution_detail.trans_date as transDate')->get();

        return response()->json($ProductionExecutionDetail);

    }
    public function deleteExecutionDetail($id)
    {
        $execution_detail = ProductionExecutionDetail::find($id);
        $execution_detail->delete();
        return response()->json('ok');
    }

    public function updateExecutionDetail(Request $request, $id_order_detail)
    {

        // $execution_detail = ProductionExecutionDetail::find($id);
        //$execution_detail = ProductionExecutionDetail::where('id_order_detail',$id)
        $order_detail = ProductionOrderDetail::find($id_order_detail);
        $unit_cost    = \DB::table('items')->where('items.id_item', $order_detail->id_item)
            ->join('item_product', 'item_product.id_item', '=', 'items.id_item')
            ->join('item_movement', 'item_movement.id_item_product', '=', 'item_product.id_item_product')
            ->join('item_movement_value', 'item_movement_value.id_movement', '=', 'item_movement.id_movement')->first();

        //$execution_detail->update(['quantity' => $request->quantity]);
        $production_execution_detail = new ProductionExecutionDetail;
        //$production_execution_detail->parent_id_execution_detail = $id;
        $production_execution_detail->quantity   = $request->quantity;
        $production_execution_detail->name       = $order_detail->name;
        $production_execution_detail->start_date = Carbon::now();
        $production_execution_detail->end_date   = Carbon::now();
        // $production_execution_detail->unit_cost  = 0;
        $production_execution_detail->is_input        = 1;
        $production_execution_detail->trans_date      = Carbon::now();
        $production_execution_detail->timestamp       = Carbon::now();
        $production_execution_detail->id_company      = 1;
        $production_execution_detail->id_user         = 1;
        $production_execution_detail->is_head         = 1;
        $production_execution_detail->is_read         = 1;
        $production_execution_detail->id_order_detail = $id_order_detail;
        $production_execution_detail->id_project_task = $order_detail->id_project_task;
        $production_execution_detail->id_item         = $order_detail->id_item;
        $production_execution_detail->unit_cost       = $unit_cost->unit_cost ?? 0;
        $production_execution_detail->save();

        return response()->json(['message' => true,
            'data'                             => ['id' => $production_execution_detail->id_execution_detail, 'name' => $production_execution_detail->name, 'quantity' => $production_execution_detail->quantity, 'unit_cost' => $production_execution_detail->unit_cost]]);

    }

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

            $production_execution_detail                          = new ProductionExecutionDetail;
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

    public function SaveExcustion($orderdetailid)
    {

        $production_order_detail = ProductionOrderDetail::find($orderdetailid);
          $production_order = ProductionOrder::find($production_order_detail->id_production_order);

        //return response()->json($request->all());


                $production_execution_detail = new ProductionExecutionDetail;


                $production_execution_detail->id_order_detail = $production_order_detail->id_order_detail;

                $production_execution_detail->quantity = 1;

                $production_execution_detail->start_date = $production_order->start_date_est;

                $production_execution_detail->end_date = $production_order->end_date_est;

                $production_execution_detail->unit_cost = 0;

                $production_execution_detail->is_input = 1;

                $production_execution_detail->trans_date = Carbon::now();

                $production_execution_detail->timestamp = Carbon::now();

                $production_execution_detail->id_company = $production_order->id_company;

                $production_execution_detail->id_user = 1;

                $production_execution_detail->is_head = 1;

                $production_execution_detail->is_read = 1;

                $production_execution_detail->id_item = $production_order_detail->id_item;

                $production_execution_detail->save();


                      return response()->json("Save");




    }
    public function SaveExcustionQuantiy($orderdetailid,$qty)
    {

        $production_order_detail = ProductionOrderDetail::find($orderdetailid);
          $production_order = ProductionOrder::find($production_order_detail->id_production_order);

        //return response()->json($request->all());


                $production_execution_detail = new ProductionExecutionDetail;


                $production_execution_detail->id_order_detail = $production_order_detail->id_order_detail;

                $production_execution_detail->quantity = $qty;

                $production_execution_detail->start_date = $production_order->start_date_est;

                $production_execution_detail->end_date = $production_order->end_date_est;

                $production_execution_detail->unit_cost = 0;

                $production_execution_detail->is_input = 1;

                $production_execution_detail->trans_date = Carbon::now();

                $production_execution_detail->timestamp = Carbon::now();

                $production_execution_detail->id_company = $production_order->id_company;

                $production_execution_detail->id_user = 1;

                $production_execution_detail->is_head = 1;

                $production_execution_detail->is_read = 1;

                $production_execution_detail->id_item = $production_order_detail->id_item;

                $production_execution_detail->save();


                      return response()->json("Save");




    }
    public function RemoveExcustion($orderdetailid)
    {

        $production_order_detail = ProductionOrderDetail::find($orderdetailid);
        $execution_detail = ProductionExecutionDetail::where('id_order_detail',$orderdetailid)->orderBy('id_execution_detail', 'desc')->first();

        $execution_detail->delete();
        return response()->json('ok');








    }

    public function approveExcecution($id)
    {

        $production_execution = ProductionExecution::find($id);

        if ($production_execution != null) {

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

        $item = Item::where('id_item', '=', $array_transactions->id_item)->first();
        if (isset($item)) {
            if ($item->id_item_type == 1 || $item->id_item_type == 2 || $item->id_item_type == 6) {
                $item_product = Item_Product::where('id_item', '=', $array_transactions->id_item)->first();
                $orderdetail  = ProductionOrderDetail::where('id_order_detail', '=', $array_transactions->id_order_detail)->first();
                $order        = ProductionOrder::where('id_production_order', '=', $orderdetail->id_order_detail)->first();
                $line         = productionLine::where('id_production_line', '=', $order->id_production_line)->first();
                if (isset($item_product)) {
                    if ($array_transactions->is_input) {
                        if ($array_transactions->quantity_excution > 0) {
                            $sql = 'select
                                  loc.id_location as LocationID,
                                  loc.name as Location,
                                  parent.id_movement as MovementID,
                                  parent.trans_date as TransDate, parent.expire_date,parent.code,
                                  parent.credit - if( sum(child.debit) > 0, sum(child.debit), 0 ) as QtyBalance,
                                  (select sum(unit_value) from item_movement_value as parent_val where id_movement = parent.id_movement) as Cost

                                  from item_movement as parent
                                  inner join app_location as loc on parent.id_location = loc.id_location
                                  left join item_movement as child on child.parent_id_movement = parent.id_movement

                                  where parent.id_location=' . strval($line->id_location) . ' and parent.id_item_product = ' . strval($item_product->id_item_product) . ' and parent.status = 2 and parent.debit = 0
                                  group by parent.id_movement
                                  order by parent.trans_date';
                            // $instocklist=  DB::select($sql);
                            $item_movement                  = new ItemMovement;
                            $item_movement->comment         = Comment;
                            $item_movement->id_item_product = $item_product->id_item_product;
                            $item_movement->debit           = $array_transactions->quantity_excution;
                            $item_movement->credit          = 0;
                            $item_movement->status          = 3;
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
    public function approve_execustion(Request $request)
    {

        $array_transactions = $request->production;
        if (isset($array_transactions)) {
            $item = Item::where('id_item', '=', $array_transactions->id_item)->first();
            if (isset($item)) {
                if ($item->id_item_type == 1 || $item->id_item_type == 2 || $item->id_item_type == 6) {
                    $item_product = Item_Product::where('id_item', '=', $array_transactions->id_item)->first();
                    $orderdetail  = ProductionOrderDetail::where('id_order_detail', '=', $array_transactions->id_order_detail)->first();
                    $order        = ProductionOrder::where('id_production_order', '=', $orderdetail->id_order_detail)->first();
                    $line         = productionLine::where('id_production_line', '=', $order->id_production_line)->first();
                    if (isset($item_product)) {
                        if ($array_transactions->is_input) {
                            if ($array_transactions->quantity_excution > 0) {
                                $sql = 'select
                                        loc.id_location as LocationID,
                                        loc.name as Location,
                                        parent.id_movement as MovementID,
                                        parent.trans_date as TransDate, parent.expire_date,parent.code,
                                        parent.credit - if( sum(child.debit) > 0, sum(child.debit), 0 ) as QtyBalance,
                                        (select sum(unit_value) from item_movement_value as parent_val where id_movement = parent.id_movement) as Cost

                                        from item_movement as parent
                                        inner join app_location as loc on parent.id_location = loc.id_location
                                        left join item_movement as child on child.parent_id_movement = parent.id_movement

                                        where parent.id_location=' . strval($line->id_location) . ' and parent.id_item_product = ' . strval($item_product->id_item_product) . ' and parent.status = 2 and parent.debit = 0
                                        group by parent.id_movement
                                        order by parent.trans_date';
                                // $instocklist=  DB::select($sql);
                                $item_movement                  = new ItemMovement;
                                $item_movement->comment         = Comment;
                                $item_movement->id_item_product = $item_product->id_item_product;
                                $item_movement->debit           = $array_transactions->quantity_excution;
                                $item_movement->credit          = 0;
                                $item_movement->status          = 3;
                                //Check for Better Code.
                                $item_movement->id_location = $line->id_location;
                                $item_movement->save();
                            }
                        }

                    }
                }
            }

        }

        return response()->json(['message' => 'transactions ok']);

    }

    public function updateProductionExecutionDetail(Request $request)
    {

        $production_order_detail = ProductionExecutionDetail::find($request->pk);

        if ($production_order_detail) {

            $production_order_detail->quantity = $request->value;
            $production_order_detail->save();
        }
    }

    public function finishExecution($id_order)
    {
        $production_order = ProductionOrder::find($id_order);
        $production_order->status = 4;
        $production_order->save();
        ProductionOrderDetail::where('id_production_order',$id_order)->update(['status'=>4]);
        $order_detail = ProductionOrderDetail::where('id_production_order',$id_order)->get();
        foreach ($order_detail as $key => $value) {
           ProductionExecutionDetail::where('id_order_detail',$value->id_order_detail)->update(['status'=>4]);
        }
        return response()->json('ok',200);
    }
}
