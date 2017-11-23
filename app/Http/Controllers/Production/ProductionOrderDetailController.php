<?php

namespace App\Http\Controllers\Production;

use App\Contact;
use App\Http\Controllers\Controller;
use App\ProductionLine;
use App\ProductionOrder;
use App\ProductionOrderDetail;
use App\Items;
use App\Project;
use App\ProjectTag;
use App\ProjectTask;
use App\ProjectTemplate;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductionOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

    public function update(Request $request, $id)
    {

        $ProductionOrderDetail            = ProductionOrderDetail::find($id);
        $ProductionOrderDetail->name        = $request->name;
        $ProductionOrderDetail->quantity = $request->quantity;
        $ProductionOrderDetail->save();
        $production_order = ProductionOrder::findOrFail($ProductionOrderDetail->id_production_order);
        //dd($production_order);
        $start_date = new Carbon($production_order->start_date_est);
        $end_date   = new Carbon($production_order->end_date_est);

        $production_order->start_date_est = $start_date->format('d/m/Y H:i');
        $production_order->end_date_est   = $end_date->format('d/m/Y H:i');

        $contacts  = Contact::all()->lists('name', 'id_contact');
        $templates = Project::whereNotNull('id_project_template')->select(DB::raw('name,concat(id_project,"-",id_project_template) as id_project_id_project_template'))->lists('name', 'id_project_id_project_template');
        //$templates->prepend('', '');
        $project_tags    = ProjectTag::all()->lists('name', 'id_tag');
        $production_line = ProductionLine::all()->lists('name', 'id_production_line');
        $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($ProductionOrderDetail->id_production_order)->get();
        return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order','production_order_detail']));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editquantity(Request $request)
    {

        $ProductionOrderDetail = ProductionOrderDetail::findOrFail($request->id_order_detail);
      if (isset($ProductionOrderDetail)) {
        $production_order_execution                             = new ProductionExecutionDetail;
        $production_order_execution->id_order_detail            = $production_order_detail->id_order_detail;
        $production_order_execution->name                       = $production_order_detail->name;
        $production_order_execution->quantity                   = $production_order_detail->quantity;
        $production_order_execution->id_project_task            = $production_order_detail->id_project_task;
        $production_order_execution->id_item                    = $production_order_detail->item;
        $production_order_execution->id_company                 = 1;
        $production_order_execution->id_user                    = 1;
        $production_order_execution->is_input                   = 1;
        $production_order_execution->is_head                    = 1;
        $production_order_execution->is_read                    = 1;
        $production_order_execution->timestamp                  = Carbon::now();
        $production_order_execution->trans_date                 = Carbon::now();
        $production_order_execution->start_date                 = $production_order_detail->start_date_est;
        $production_order_execution->end_date                   = $production_order_detail->end_date_est;
        $production_order_execution->save();
      return response()->json($ProductionOrderDetail);
      }



    }
    public function edit($id)
    {
      $production_execution_detail=ProductionOrderDetail::where('id_order_detail','=',$id)->first();


      return view('Production/form_production_order_detail', compact('production_execution_detail'));





    }
    public function showdetail($id)
    {
        $ProductionOrderDetail = ProductionOrderDetail::Join('security_user', 'security_user.id_user', '=', 'production_order_detail.id_user')->where('id_order_detail','=',$id)
        ->select('security_user.name',\DB::raw("ROUND(production_order_detail.quantity,2) as quantity "),\DB::raw("DATE(production_order_detail.timestamp) as timestamp"))
        ->get();


        return response()->json($ProductionOrderDetail);
    }

  /*  public function updateProductionOrderDetail(Request $request)
    {

            $production_order_detail = ProductionOrderDetail::find($request->pk);

            if($production_order_detail){

                $production_order_detail->quantity = $request->value;
                $production_order_detail->save();
            }
    }*/

    public function updateProductionOrderDetail(Request $request, $name_field)
    {

        //type 1 start date and 2 end date
       $production_order_detail = ProductionOrderDetail::find($request->pk);

            if($production_order_detail){
                $production_order_detail->$name_field = $request->value;
                $production_order_detail->save();
            }
    }

    public function insertTask($quantity, $parent, $item_id, $id_project)
    {
        // = explode("\t", $name);

        //dd(count($array_aux));
        $id_project_task = null;
        if ($id_project != null) {
            $project_task                         = new ProjectTask;
            $project_task->id_project             = $id_project;
            $project_task->id_company             = 1;
            $project_task->id_user                = 1;
            $project_task->is_active              = 1;
            $project_task->is_head                = 1;
            $project_task->is_read                = 1;
            $project_task->timestamp              = Carbon::now();
            $project_task->trans_date             = Carbon::now();
            $project_task->id_item                = $item_id;
            $project_task->quantity_est           = $quantity;
            $project_task->parent_id_project_task = $parent;
            $project_task->save();
            $id_project_task = $project_task->getKey();
        }

        return $id_project_task;

    }

    public function addOrderDetail(Request $request)
    {
        //dd($request->all());
        $production_order = ProductionOrder::find($request->id_production_order);
        if($request->parent_id_order_detail != ''){
           $parent_task =  ProductionOrderDetail::find($request->parent_id_order_detail)->id_project_task_task;
       }else{
        $parent_task = null;
       }

        $id_project_task = $this->insertTask($request->quantity, $parent_task, $request->id_item, $production_order->id_project);
        $production_order_detail = new ProductionOrderDetail;
         $production_order_detail->id_production_order    = $request->id_production_order;
        $production_order_detail->name                   = Items::find($request->id_item)->name;
        $production_order_detail->quantity               = $request->quantity;
        $production_order_detail->id_project_task        = $id_project_task;
        $production_order_detail->id_item                = $request->id_item;
        $production_order_detail->id_company             = 1;
        $production_order_detail->id_user                = 1;
        $production_order_detail->is_input               = 1;
        $production_order_detail->is_head                = 1;
        $production_order_detail->is_read                = 1;
        $production_order_detail->timestamp              = Carbon::now();
        $production_order_detail->trans_date             = Carbon::now();
        $production_order_detail->start_date_est         = Carbon::now();
        $production_order_detail->end_date_est           = Carbon::now()->addDay();
        $production_order_detail->parent_id_order_detail = $request->parent_id_order_detail != '' ? : null;
        $production_order_detail->save();
        return redirect()->back();
    }
    public function destroy($id)
    {
       $detail = ProductionOrderDetail::find($id);
       $detail->delete();
       return redirect()->back();
    }

}
