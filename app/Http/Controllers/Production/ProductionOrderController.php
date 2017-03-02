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

                $parent = $array_parent->where('id', $value->parent)->first();

                if (count($parent)) {

                    $parent_real      = $parent['id_real'];
                    $parent_real_task = $parent['id_real_task'];
                    $id_project_task  = $this->insertTask($value->text, $parent_real_task, $value->data->id_item, $id_project);
                    $id_real          = $this->insertProductionOrderDetail($value->text, $parent_real, $production_order->getKey(), $value->data->id_item, $id_project_task);
                    $array_parent->push(['id' => $value->id, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);
                    $cont++;

                }

            }

        }

        return redirect()->route('production_order.index');
    }

    public function storeOTExcel(Request $request)
    {
        //leer archivo
        $results = Excel::load($request->file, function ($reader) {

        })->get();

        foreach ($results as $key => $value) {

            //buscar linea de produccion, si no existe crear
            $production_line = ProductionLine::where('name', $value->linea_trabajo)->first();

            if ($production_line != null) {

                $id_production_line = $production_line->id_production_line;

            } else {

                $id_production_line = $this->storePL($value->linea_trabajo);

            }
            //insertar cliente y contacto cliente es padre de contacto

            $client = Contact::where('code', $value->codcliente)->first();

            if ($client == null) {

                $id_parent = $this->storeContact($value);

                $id_contact = $this->storeContact($value, $id_parent);

            } else {

                $id_contact = $this->storeContact($value, $client->id_contact);
            }
            //buscar plantilla si no existe insertar platilla y proyecto
            $template = ProjectTemplate::where('name', trim($value->tipotrabajo))->first();

            if ($template != null) {

                $id_project = $this->storeTemplateProject($value->tipotrabajo, $id_contact, $template->id_project_template);

            } else {

                $id_project = $this->storeTemplateProject($value->tipotrabajo, $id_contact);

            }

            //insertar OT
            $production_order = ProductionOrder::where('work_number', $value->solicitud)->first();

            if ($production_order == null) {

                $this->storeOT($value, $id_project, $id_production_line);
            }

        }

        return redirect()->back();
    }

    public function storePL($name)
    {

        $production_line = new ProductionLine;

        $production_line->id_location = 1;

        $production_line->name = $name;

        $production_line->id_company = Auth::user()->id_company;

        $production_line->id_user = Auth::user()->id_user;

        $production_line->is_head = 1;

        $production_line->is_read = 1;

        $production_line->timestamp = Carbon::now();

        $production_line->save();

        return $production_line->getKey();
    }

    public function storeContact($request, $parent = null)
    {

        $client = new Contact;

        $client->id_company      = Auth::user()->id_company;
        $client->id_user         = Auth::user()->id_user;
        $client->is_read         = 0;
        $client->is_head         = 1;
        $client->timestamp       = Carbon::now();
        $client->is_active       = 1;
        $client->is_customer     = 1;
        $client->is_supplier     = 0;
        $client->is_employee     = 0;
        $client->is_sales_rep    = 0;
        $client->is_person       = 1;
        $client->id_contact_role = 1;

        if ($parent == null) {
            $client->code    = $request->codcliente;
            $client->name    = $request->cliente;
            $client->address = $request->direccion;

        } else {
            $client->name = $request->contacto;
        }

        $client->parent_id_contact = $parent;
        $client->save();

        return $client->getKey();
    }

    public function storeTemplateProject($name, $id_contact, $id_project_template = null)
    {

        if ($id_project_template == null) {

            $project_template                 = new ProjectTemplate;
            $project_template->name           = $name;
            $project_template->id_item_output = 1;
            $project_template->id_company     = 1;
            $project_template->id_user        = 1;
            $project_template->is_active      = 1;
            $project_template->is_head        = 1;
            $project_template->is_read        = 1;
            $project_template->timestamp      = Carbon::now();
            $project_template->save();

            $project                      = new Project;
            $project->id_project_template = $project_template->getKey();
            $project->id_contact          = $id_contact;
            $project->name                = $name;
            $project->priority            = 1;
            $project->id_company          = 1;
            $project->id_user             = 1;
            $project->is_active           = 1;
            $project->is_head             = 1;
            $project->is_read             = 1;
            $project->timestamp           = Carbon::now();
            $project->save();
            return $project->getKey();
        }
        $project = Project::where('id_project_template', $id_project_template)->first();

        if ($project) {
            return $project->getKey();
        }

        $project                      = new Project;
        $project->id_project_template = $id_project_template;
        $project->id_contact          = $id_contact;
        $project->name                = $name;
        $project->priority            = 1;
        $project->id_company          = 1;
        $project->id_user             = 1;
        $project->is_active           = 1;
        $project->is_head             = 1;
        $project->is_read             = 1;
        $project->timestamp           = Carbon::now();
        $project->save();
        return $project->getKey();
    }

    public function storeOT($request, $id_project, $id_production_line)
    {
        $production_order                     = new ProductionOrder;
        $production_order->id_production_line = $id_production_line;
        $production_order->id_project         = $id_project;
        $production_order->name               = $request->tipotrabajo;
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
        $production_order->work_number        = $request->solicitud;
        $production_order->save();
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

                $production_order_detail = ProductionOrderDetail::find($value->id);

                if ($production_order_detail) {

                    $this->updateProductionOrderDetail($value->text, $production_order_detail);
                    //  $this->updateTask($value->text, $id_project_task);

                } else {

                    if ($value->parent == "#") {
                        $cont            = 0;
                        $array_parent    = collect();
                        $id_project_task = $this->insertTask($value->text, null, $value->data->id_item, $id_project);
                        $id_real         = $this->insertProductionOrderDetail($value->text, null, $production_order->getKey(), $value->data->id_item, $id_project_task);
                        $array_parent->push(['id' => $value->id, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);

                    } else {

                        $parent = $array_parent->where('id', $value->parent)->first();

                        if (count($parent)) {
                            $parent_real      = $parent['id_real'];
                            $parent_real_task = $parent['id_real_task'];
                            $id_project_task  = $this->insertTask($value->text, $parent_real_task, $value->data->id_item, $id_project);
                            $id_real          = $this->insertProductionOrderDetail($value->text, $parent_real, $production_order->getKey(), $value->data->id_item, $id_project_task);
                            $array_parent->push(['id' => $value->id, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);
                            $cont++;
                        }
                    }
                }
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

    public function updateProductionOrderDetail($name, $production_order_detail)
    {

        $array_aux                         = explode("\t", $name);
        $production_order_detail->name     = $array_aux[0];
        $production_order_detail->quantity = count($array_aux) > 1 ? $array_aux[1] : 0;
        $production_order_detail->save();

        return $production_order_detail->id_project_task;

    }

//Api Methods

    public function productionOrderByLine($id_line)
    {

        $production_orders = ProductionOrder::where('id_production_line', $id_line)->where('status', '=', 2)->get();

        return response()->json($production_orders);

    }

    public function productionOrderDetail($id_order)
    {

        $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($id_order)->get();

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
