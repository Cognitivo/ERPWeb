<?php

namespace App\Http\Controllers\Production;

use App\Contact;
use App\Http\Controllers\Controller;
use App\ProductionExecutionDetail;
use App\ProductionLine;
use App\ProductionOrder;
use App\ProductionOrderDetail;
use App\Project;
use App\ProjectTag;
use App\ProjectTask;
use App\ProjectTemplate;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Facades\Datatables;

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(ProductionOrderDetail::ApiGetProductionOrderDetail(1)->get());
        if (\Request::ajax()) {
            return $this->indexData();
        }
        //$order = ProductionOrder::all();

        return view('Production/list_production_order');
    }

    public function indexData()
    {

        $orders = ProductionOrder::leftJoin('production_line', 'production_line.id_production_line', '=', 'production_order.id_production_line')->

            select(['id_production_order', 'work_number', 'production_order.name', 'production_line.name as linea', 'status'])->get();

        return Datatables::of($orders)

            ->addColumn('actions', function ($order) {
                $result = '';
                if ($order->status == 1) {
                    $result = '<a href="/production_order/' . $order->id_production_order . '/edit" class="btn btn-sm btn-primary" >
                <i class="glyphicon glyphicon-edit"></i>
                </a>
                <form action="/production_order/' . $order->id_production_order . '"  method= "post" style =" display : inline;">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_method" value="DELETE">
                     <button type="submit" class="btn btn-sm btn-icon-only red glyphicon glyphicon-trash " style="height : 30px !important;"></button>
                </form>';

                    $status = $order->productionOrderDetail()->first() != null ? $order->productionOrderDetail()->first()->status : null;
                    if ($status != 2) {
                        $result = $result . '
                             <a href="/approved_production_order/' . $order->id_production_order . '" class="btn btn-sm purple">
                            <i class="fa fa-file-o"></i> Aprobar </a>
                     ';

                    } else {
                        $result = '<a href="/production_order/' . $order->id_production_order . '/edit" class="btn btn-sm btn-primary" >
                        <i class="glyphicon glyphicon-eye-open"></i>
                        </a>';
                    }
                }else{
                     $result = '<a href="/production_order/' . $order->id_production_order . '/edit" class="btn btn-sm btn-primary" >
                        <i class="glyphicon glyphicon-eye-open"></i>
                        </a>';
                }

                return $result;

            })->editColumn('status', function ($order) {

            $status = $order->productionOrderDetail()->first() != null ? $order->productionOrderDetail()->first()->status : null;
            if ($status == 2) {
                return 'Aprobado';
            } else if ($status == 4) {
                return 'Terminado';
            } else {
                return 'Pendiente';
            }
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

        $contacts  = Contact::all()->lists('name', 'id_contact');
        $templates = ProjectTemplate::all()->lists('name', 'id_project_template');

        $project_tags            = ProjectTag::all()->lists('name', 'id_tag');
        $production_line         = ProductionLine::all()->lists('name', 'id_production_line');
        $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail(0)->get();
        return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order_detail']));

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
        //get relation project the contact
        $project = Project::where('id_contact', $request->id_contact)->where('id_project_template', $request->id_project_template)->first();
        if ($project) {
            $id_project = $project->getKey();
        } else {
            //save project
            if ($request->id_contact != "") {
                $project                      = new Project;
                $project->id_project_template = $request->id_project_template;
                $project->name                = $request->name_project_template[$request->id_project_template];
                $project->id_contact          = $request->id_contact;
                $project->priority            = 1;
                $project->id_company          = 1;
                $project->id_user             = 1;
                $project->is_active           = 1;
                $project->is_head             = 1;
                $project->is_read             = 1;
                $project->timestamp           = Carbon::now();
                $project->save();
                $id_project = $project->getKey();
            }

        }

        $range_date = explode("-", $request->range_date);

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
        $production_order->work_number        = $request->work_number;
        $production_order->save();

        //insert task and order detail
        $template_detail = ProjectTemplate::find($request->id_project_template);
        //insertTask($name, $parent, $item, $id_project)
        if ($template_detail->get()->count()) {
            $this->insertDetail($template_detail, $production_order, $id_project);
        }

        return redirect()->back();

    }

    public function storeOTExcel(Request $request)
    {
        //leer archivo
        $results = Excel::load($request->file, function ($reader) {

        })->get();

        foreach ($results as $key => $value) {

            //verificar si el estado es asignado para insertar
            if (strpos(strtolower(trim($value->estado)), 'asig') !== false) {
                //buscar linea de produccion, si no existe crear
                $production_line = ProductionLine::where('name', $value->linea_trabajo)->first();

                if ($production_line != null) {

                    $id_production_line = $production_line->id_production_line;

                } else {

                    $id_production_line = $this->storePL($value->linea_trabajo);

                }
                //insertar cliente y contacto cliente es padre de contacto
                //insertar contacto solo si no existe
                //validar por nombre
                $client = Contact::where('code', $value->codcliente)->first();

                if (!$client) {

                    $id_parent = $this->storeContact($value);

                    $id_contact = $this->storeContact($value, $id_parent);

                } else {
                    $contact = Contact::where('parent_id_contact', $client->id_contact)->where('name', trim($value->contacto))->first();

                    if (!$contact) {
                        $id_contact = $this->storeContact($value, $client->id_contact);
                    } else {
                        $id_contact = $contact->id_contact;
                    }

                }
                //buscar plantilla si no existe insertar platilla y proyecto
                //sustituir tipo de trabajo por template
                $template = ProjectTemplate::where('name', trim($value->template))->first();

                if ($template != null) {

                    $id_project = $this->storeTemplateProject($value->template, $id_contact, $template->id_project_template);

                } else {

                    $id_project = $this->storeTemplateProject($value->template, $id_contact);

                }

                //insertar OT
                $production_order = ProductionOrder::where('work_number', $value->solicitud)->first();

                if ($production_order == null) {
                    $this->storeOT($value, $id_project, $id_production_line);
                }
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
            $client->name      = $request->contacto;
            $client->telephone = $request->telefono_contacto;
            //verificar direccion de cliente si no existe crear en una nueva direccion para el contacto
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

        }
        $project                      = new Project;
        $project->id_project_template = $id_project_template != null ? $id_project_template : $project_template->getKey();
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
        $production_order->name               = $request->template;
        $production_order->trans_date         = $request->fecha_de_asignacion;
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

        //insert task and order detail
        $project         = Project::find($id_project);
        $template_detail = ProjectTemplate::find($project->id_project_template);
        //insertTask($name, $parent, $item, $id_project)
        if ($template_detail->get()->count()) {
            $this->insertDetail($template_detail, $production_order, $id_project);
        }
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
    public function edit($id, Request $request)
    {
        //if ($id!='0') {
        //session()->put('id', $id);
        $production_order = ProductionOrder::findOrFail($id);
        //dd($production_order);
        $start_date = new Carbon($production_order->start_date_est);
        $end_date   = new Carbon($production_order->end_date_est);

        $production_order->start_date_est = $start_date->format('d/m/Y H:i');
        $production_order->end_date_est   = $end_date->format('d/m/Y H:i');

        $contacts                = Contact::all()->lists('name', 'id_contact');
        $templates               = ProjectTemplate::all()->lists('name', 'id_project_template');
        $project_tags            = ProjectTag::all()->lists('name', 'id_tag');
        $production_line         = ProductionLine::all()->lists('name', 'id_production_line');
        $production_order_detail = ProductionOrderDetail::GetOrderDetail($id)->get();
        return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order', 'production_order_detail']));

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
        //dd($request->all());
        $range_date = explode("-", $request->range_date);

        $production_order = ProductionOrder::findOrFail($id);

        $id_project = null;
        //get relation project the contact
        $project = Project::where('id_contact', $request->id_contact)->where('id_project_template', $request->id_project_template)->first();
        if ($project) {
            $id_project = $project->getKey();
        } else {
            //save project
            if ($request->id_contact != "") {
                $project                      = new Project;
                $project->id_project_template = $request->id_project_template;
                $project->name                = $request->name_project_template[$request->id_project_template];
                $project->id_contact          = $request->id_contact;
                $project->priority            = 1;
                $project->id_company          = 1;
                $project->id_user             = 1;
                $project->is_active           = 1;
                $project->is_head             = 1;
                $project->is_read             = 1;
                $project->timestamp           = Carbon::now();
                $project->save();
                $id_project = $project->getKey();
            }

        }

        $production_order->id_production_line = $request->id_production_line;
        $production_order->work_number        = $request->work_number;
        $production_order->name               = $request->name;
        $production_order->status             = 1;
        $production_order->work_number        = $request->work_number;
        $production_order->timestamp          = Carbon::now();
        $production_order->start_date_est     = Controller::convertDate($range_date[0]);
        $production_order->end_date_est       = Controller::convertDate($range_date[1]);

        //if change template delete project template current an insert new

        if ($production_order->project->id_project_template != $request->id_project_template) {
            $production_order->id_project = $id_project;
            if ($production_order->productionOrderDetail()->get()->count()) {

                $production_order->productionOrderDetail()->delete();
            }

            //insert task and order detail
            $template_detail = ProjectTemplate::find($request->id_project_template);
            //dd($template_detail);
            //insertTask($name, $parent, $item, $id_project)
            if ($template_detail->get()->count()) {
                $this->insertDetail($template_detail, $production_order, $id_project);
            }
        }
        $production_order->save();

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
        //dd($id);
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

    public function insertDetail($template_detail, $production_order, $id_project)
    {
        $array        = $template_detail->details()->get();
        $array_result = collect();
        $array_parent = collect();
        $cont         = 0;

        foreach ($array as $key => $value) {

            if ($value->parent_id_template_detail == null) {
                $cont            = 0;
                $array_parent    = collect();
                $id_project_task = $this->insertTask(0, null, $value->id_item, $id_project);
                $id_real         = $this->insertProductionOrderDetail($value->item_description, 0, null, $production_order, $value->id_item, $id_project_task);
                $array_parent->push(['id' => $value->id_template_detail, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);

            } else {

                $parent = $array_parent->where('id', $value->parent_id_template_detail)->first();

                if (count($parent)) {

                    $parent_real      = $parent['id_real'];
                    $parent_real_task = $parent['id_real_task'];
                    $id_project_task  = $this->insertTask(0, $parent_real_task, $value->id_item, $id_project);
                    $id_real          = $this->insertProductionOrderDetail($value->item_description, 0, $parent_real, $production_order, $value->id_item, $id_project_task);
                    $array_parent->push(['id' => $value->id_template_detail, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);
                    $cont++;

                }

            }

        }
    }

    public function insertDetailExecution($production_order_detail)
    {
        $array        = $production_order_detail->get();
        $array_result = collect();
        $array_parent = collect();
        $cont         = 0;

        foreach ($array as $key => $value) {

            if ($value->parent_id_order_detail == null) {
                $cont            = 0;
                $array_parent    = collect();
                $id_project_task = $value->id_project_task;
                $id_real         = $this->insertProductionExecutionDetail($value->name, $value->quantity, null, $value, $value->id_item, $id_project_task);
                $array_parent->push(['id' => $value->id_order_detail, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);

            } else {

                $parent = $array_parent->where('id', $value->parent_id_order_detail)->first();

                if (count($parent)) {

                    $parent_real      = $parent['id_real'];
                    $parent_real_task = $parent['id_real_task'];
                    $id_project_task  = $value->id_project_task;
                    $id_real          = $this->insertProductionExecutionDetail($value->name, $value->quantity, $parent_real, $value, $value->id_item, $id_project_task);
                    $array_parent->push(['id' => $value->id_order_detail, 'id_real' => $id_real, 'id_real_task' => $id_project_task]);
                    $cont++;

                }

            }

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

    public function updateTask($name, $id)
    {
        $array_aux                  = explode("\t", $name);
        $project_task               = ProjectTask::findOrFail($id);
        $project_task->quantity_est = count($array_aux) > 1 ? $array_aux[1] : 0;
        $project_task->save();

    }

    public function insertProductionOrderDetail($name, $quantity, $parent, $production_order, $item, $id_project_task)
    {
        //$array_aux                                       = explode("\t", $name);
        $production_order_detail                         = new ProductionOrderDetail;
        $production_order_detail->id_production_order    = $production_order->getKey();
        $production_order_detail->name                   = $name;
        $production_order_detail->quantity               = $quantity;
        $production_order_detail->id_project_task        = $id_project_task;
        $production_order_detail->id_item                = $item;
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
        $production_order_detail->parent_id_order_detail = $parent;
        $production_order_detail->save();

        return $production_order_detail->getKey();
    }

    public function insertProductionExecutionDetail($name, $quantity, $parent, $production_order_detail, $item, $id_project_task)
    {

        //$array_aux                                       = explode("\t", $name);
        $production_order_execution                  = new ProductionExecutionDetail;
        $production_order_execution->id_order_detail = $production_order_detail->id_order_detail;
        $production_order_execution->name            = $name;
        $production_order_execution->quantity        = $quantity;
        $production_order_execution->id_project_task = $id_project_task;
        $production_order_execution->id_item         = $item;
        $production_order_execution->status          = 2;
        $production_order_execution->id_company      = 1;
        $production_order_execution->id_user         = 1;
        $production_order_execution->is_input        = 1;
        $production_order_execution->is_head         = 1;
        $production_order_execution->is_read         = 1;
        $production_order_execution->timestamp       = Carbon::now();
        $production_order_execution->trans_date      = Carbon::now();
        if ($production_order_detail->start_date_est != null) {
            $production_order_execution->start_date = Carbon::createFromFormat('d/m/Y H:i:s', $production_order_detail->start_date_est);
        } else {
            $production_order_execution->start_date = Carbon::now();
        }
        if ($production_order_detail->end_date_est != null) {
            $production_order_execution->end_date = Carbon::createFromFormat('d/m/Y H:i:s', $production_order_detail->end_date_est);
        } else {
            $production_order_execution->end_date = Carbon::now();
        }

        $production_order_execution->parent_id_execution_detail = $parent;

        $production_order_execution->save();

        return $production_order_execution->getKey();
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
        \Log::info('entro'.$id_line);
        $production_orders = ProductionOrder::where('id_production_line', $id_line)->where('status', 2)->select('id_production_order as id', 'name', 'id_production_line')->get();

        return response()->json($production_orders);

    }

    public function productionOrderDetail($id_order)
    {

        $production_order_detail = ProductionOrderDetail::ApiGetProductionOrderDetail($id_order)->get();

        return response()->json($production_order_detail);

    }

    public function changeStatusApproved($id)
    {

        $production_order = ProductionOrder::findOrFail($id);

        $production_order_detail = $production_order->productionOrderDetail();

        foreach ($production_order_detail->get() as $key => $value) {
            $value->status = 2;
            $value->save();
            //$value->update(['status' => 2]);

        }
        //dd("ok");
        $production_order->status = 2;

        $production_order->save();

        //insert in production excecution
        //$this->insertDetailExecution($production_order_detail);

        return redirect()->back();

    }
    /*  public function storeTemplate(Request $request)
{

if (isset($request)) {
if (isset($request->id_project_template)) {
$id_project = session()->get('id_project');
$project    = null;
if (isset($id_project)) {
$project                      = Project::where('id_project', '=', $id_project)->first();
$project->id_project_template = $request->id_project_template;
}
$id_production_order = session()->get('id_production_order');
$parent              = ProjectTemplateDetail::where('parent_id_template_detail', '=', null)->get();
foreach ($parent as $detail) {
$child = ProjectTemplateDetail::where('parent_id_template_detail', '=', $detail->id_template_detail)->get();
if (isset($project)) {
$project_task                         = new ProjectTask;
$project_task->id_project             = $id_project;
$project_task->id_company             = 1;
$project_task->id_user                = 1;
$project_task->is_active              = 1;
$project_task->is_head                = 1;
$project_task->is_read                = 1;
$project_task->timestamp              = Carbon::now();
$project_task->trans_date             = Carbon::now();
$project_task->id_item                = $detail->id_item;
$project_task->code                   = $detail->code;
$project_task->item_description       = $detail->item_description;
$project_task->quantity_est           = 0;
$project_task->parent_id_project_task = null;
$project_task->save();
}

if (isset($id_production_order)) {
$production_order_detail                      = new ProductionOrderDetail;
$production_order_detail->id_production_order = $id_production_order;
$production_order_detail->name                = $detail->item_description;
$production_order_detail->quantity            = 0;
if (isset($project_task)) {
$production_order_detail->id_project_task = $project_task->$id_project_task;
}

$production_order_detail->id_item                = $detail->id_item;
$production_order_detail->id_company             = 1;
$production_order_detail->id_user                = 1;
$production_order_detail->is_input               = 1;
$production_order_detail->is_head                = 1;
$production_order_detail->is_read                = 1;
$production_order_detail->timestamp              = Carbon::now();
$production_order_detail->trans_date             = Carbon::now();
$production_order_detail->parent_id_order_detail = null;
$production_order_detail->save();

}
foreach ($child as $detailchild) {
if (isset($project)) {
$project_taskchild                         = new ProjectTask;
$project_taskchild->id_project             = $id_project;
$project_taskchild->id_company             = 1;
$project_taskchild->id_user                = 1;
$project_taskchild->is_active              = 1;
$project_taskchild->is_head                = 1;
$project_taskchild->is_read                = 1;
$project_taskchild->timestamp              = Carbon::now();
$project_taskchild->trans_date             = Carbon::now();
$project_taskchild->id_item                = $detail->id_item;
$project_taskchild->code                   = $detail->code;
$project_taskchild->item_description       = $detail->item_description;
$project_taskchild->quantity_est           = 0;
$project_taskchild->parent_id_project_task = $project_task->id_project_task;
$project_taskchild->save();
}

if (isset($id_production_order)) {
$production_order_detailchild                      = new ProductionOrderDetail;
$production_order_detailchild->id_production_order = $id_production_order;
$production_order_detailchild->name                = $detail->item_description;
$production_order_detailchild->quantity            = 0;
if (isset($project_taskchild)) {
$production_order_detailchild->id_project_task = $project_taskchild->$id_project_task;
}

$production_order_detailchild->id_item                = $detail->id_item;
$production_order_detailchild->id_company             = 1;
$production_order_detailchild->id_user                = 1;
$production_order_detailchild->is_input               = 1;
$production_order_detailchild->is_head                = 1;
$production_order_detailchild->is_read                = 1;
$production_order_detailchild->timestamp              = Carbon::now();
$production_order_detailchild->trans_date             = Carbon::now();
$production_order_detailchild->parent_id_order_detail = $production_order_detail->id_project_task;
$production_order_detailchild->save();
}
}
}
}
}
$contacts                = Contact::all()->lists('name', 'id_contact');
$templates               = ProjectTemplate::all()->lists('name', 'id_project_template');
$project_tags            = ProjectTag::all()->lists('name', 'id_tag');
$production_line         = ProductionLine::all()->lists('name', 'id_production_line');
$production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($id_production_order)->get();
return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order', 'production_order_detail']));
}*/

}
