<?php

namespace App\Http\Controllers\Production;

use App\Contact;
use App\Http\Controllers\Controller;
use App\ProductionLine;
use App\ProductionOrder;
use App\ProductionOrderDetail;
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
      $ProductionOrderDetail->quantity=$request->quantity;
      $ProductionOrderDetail->save();
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
        $ProductionOrderDetail = ProductionOrderDetail::findOrFail($id);


        return response()->json($ProductionOrderDetail);
    }


}
