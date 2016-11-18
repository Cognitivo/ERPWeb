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
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $order = ProductionOrder::all();

        return view('Production/list_production_order', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $contacts  = Contact::all()->lists('name', 'id_contact');
        $templates = Project::whereNotNull('id_project_template')->select(DB::raw('name,concat(id_project,"-",id_project_template) as id_project_id_project_template'))->lists('name', 'id_project_id_project_template');
        $templates->prepend('', '');
        $project_tags = ProjectTag::all()->lists('name', 'id_tag');

        $production_line = ProductionLine::all()->lists('name', 'id_production_line');

        return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line']));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $id_project = null;
        if ($request->id_project != "") {
            $id_project = explode("-", $request->id_project)[0];

            $project             = Project::findOrFail($id_project);
            $project->id_contact = $request->id_contact;
            $project->save();
        }

        $range_date = explode("-", $request->range_date);
        //dd($id_project);
        $production_order                     = new ProductionOrder;
        $production_order->id_production_line = $request->id_production_line;
        $production_order->id_project         = $id_project;
        $production_order->name               = $request->name;
        $production_order->trans_date         = Carbon::now();
        $production_order->id_company         = 1;
        $production_order->id_branch          = 1;
        $production_order->id_terminal        = 1;
        $production_order->id_user            = 1;
        $production_order->is_head            = 1;
        $production_order->timestamp          = Carbon::now();
        $production_order->is_head            = 1;
        $production_order->is_read            = 1;
        $production_order->start_date_est     = Controller::convertDate($range_date[0]);
        $production_order->end_date_est       = Controller::convertDate($range_date[1]);
        $production_order->status             = 1;
        $production_order->save();

        $array = json_decode($request->tree_save);

        //dd($array);
        $array_result = collect();
        $array_parent = collect();
        $cont         = 0;

        foreach ($array as $key => $value) {

            if ($value->parent == "#") {
                $cont            = 0;
                $array_parent    = collect();
                $id_project_task = $this->insertTask($value->text, null, $value->data->id_item, $id_project);
                $id_real         = $this->insertProductionOrderDetail($value->text, null, $production_order->getKey(), $value->data->id_item, $id_project_task);

                $array_parent->push(['id' => $value->id, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);
                
            } else {
                //dd($array_parent);

                //var_dump($array_parent);
                $parent = $array_parent->where('id', $value->parent)->first();

                if (count($parent)) {

                    $parent_real      = $parent['id_real'];
                    $parent_real_task = $parent['id_real_task'];
                    $id_project_task  = $this->insertTask($value->text, $parent_real_task, $value->data->id_item, $id_project);
                    $id_real          = $this->insertProductionOrderDetail($value->text, $parent_real, $production_order->getKey(), $value->data->id_item, $id_project_task);
                    $array_parent->push(['id' => $value->id, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);
                    $cont++;

                }

                //dd($array_parent);
            }

        }

        return redirect()->route('production_order.index');
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
        $production_order = ProductionOrder::findOrFail($id);

        $start_date = new Carbon($production_order->start_date_est);
        $end_date   = new Carbon($production_order->end_date_est);

        $production_order->start_date_est = $start_date->format('d/m/Y H:i');
        $production_order->end_date_est   = $end_date->format('d/m/Y H:i');

        $contacts  = Contact::all()->lists('name', 'id_contact');
        $templates = Project::whereNotNull('id_project_template')->select(DB::raw('name,concat(id_project,"-",id_project_template) as id_project_id_project_template'))->lists('name', 'id_project_id_project_template');
        //$templates->prepend('', '');
        $project_tags    = ProjectTag::all()->lists('name', 'id_tag');
        $production_line = ProductionLine::all()->lists('name', 'id_production_line');

        return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order']));
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

        if ($request->id_project != "") {

            $id_project = explode("-", $request->id_project)[0];

            $project = Project::findOrFail($id_project);

            $project->id_contact = $request->id_contact;

            $project->save();

        }

        $range_date = explode("-", $request->range_date);

        $production_order = ProductionOrder::findOrFail($id);

        $production_order->id_production_line = $request->id_production_line;

        $production_order->name = $request->name;

        $production_order->timestamp = Carbon::now();

        $production_order->start_date_est = Controller::convertDate($range_date[0]);

        $production_order->end_date_est = Controller::convertDate($range_date[1]);

        $production_order->save();

        $array = json_decode($request->tree_save);

        //dd($array);
        $array_result = collect();
        $array_parent = collect();
        $cont         = 0;

        if ($array != null) {
            foreach ($array as $key => $value) {
                $this->updateProductionOrderDetail($value->text, $value->id);
                //  $this->updateTask($value->text, $id_project_task);

            }
        }

        return redirect()->route('production_order.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $production_order = ProductionOrder::findOrFail($id);

        try {

            $production_order->delete();

            flash('Operación realizada con éxito', 'success');

            return redirect()->back();

        } catch (\Illuminate\Database\QueryException $e) {

            flash('No se puede eliminar!', 'danger');

            return redirect()->back();
        }

    }

    public function insertTask($name, $parent, $item, $id_project)
    {
        $array_aux = explode("\t", $name);

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
            $project_task->id_item                = $item;
            $project_task->quantity_est           = count($array_aux) > 1 ? $array_aux[1] : 0;
            $project_task->parent_id_project_task = $parent;
            $project_task->save();
            $id_project_task = $project_task->getKey();
        }

        return $id_project_task;

    }

    public function updateTask($name, $id)
    {
        $array_aux                  = explode("\t", $name);
        $project_task               = ProjectTask::findOrFail($id);
        $project_task->quantity_est = count($array_aux) > 1 ? $array_aux[1] : 0;
        $project_task->save();

    }

    public function insertProductionOrderDetail($name, $parent, $id_production_order, $item, $id_project_task)
    {
        $array_aux                                       = explode("\t", $name);
        $production_order_detail                         = new ProductionOrderDetail;
        $production_order_detail->id_production_order    = $id_production_order;
        $production_order_detail->name                   = $array_aux[0];
        $production_order_detail->quantity               = count($array_aux) > 1 ? $array_aux[1] : 0;
        $production_order_detail->id_project_task        = $id_project_task;
        $production_order_detail->id_item                = $item;
        $production_order_detail->id_company             = 1;
        $production_order_detail->id_user                = 1;
        $production_order_detail->is_input               = 1;
        $production_order_detail->is_head                = 1;
        $production_order_detail->is_read                = 1;
        $production_order_detail->timestamp              = Carbon::now();
        $production_order_detail->trans_date             = Carbon::now();
        $production_order_detail->parent_id_order_detail = $parent;
        $production_order_detail->save();

        return $production_order_detail->getKey();
    }

    public function updateProductionOrderDetail($name, $id)
    {

        $array_aux                         = explode("\t", $name);
        $production_order_detail           = ProductionOrderDetail::findOrFail($id);
        $production_order_detail->name     = $array_aux[0];
        $production_order_detail->quantity = count($array_aux) > 1 ? $array_aux[1] : 0;
        $production_order_detail->save();

        return $production_order_detail->id_project_task;

    }

//Api Methods

    public function productionOrderByLine($id_line)
    {

        $production_orders = ProductionOrder::where('id_production_line', $id_line)->get();

        return response()->json($production_orders);

    }

    public function productionOrderDetail($id_order)
    {

        $production_order_detail = ProductionOrderDetail::join('items', 'items.id_item', '=', 'production_order_detail.id_item')

            ->leftJoin('production_execution', 'production_execution.id_production_order', '=', 'production_order_detail.id_production_order')

            ->leftJoin('production_execution_detail', 'production_execution_detail.id_order_detail', '=', 'production_order_detail.id_order_detail')

            ->where('production_order_detail.id_production_order', $id_order)

            ->where('id_item_type', '!=', '5')

            ->select('production_order_detail.*', 'items.id_item_type', \DB::raw('ifnull(production_execution_detail.quantity,0) as quantity_excution'), 'production_execution.id_production_execution')->get();

        return response()->json($production_order_detail);

    }

    public function changeStatusApproved($id)
    {

        $production_order = ProductionOrder::findOrFail($id);

        $production_order_detail = $production_order->productionOrderDetail()->get();
       
        foreach ($production_order_detail as $key => $value) {
            $value->status = 2;
            $value->save();
            //$value->update(['status' => 2]);

        }
        //dd("ok");
        $production_order->status = 2;

        $production_order->save();

        return redirect()->back();

    }

}
