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
use App\ProjectTemplateDetail;
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
        $templates = ProjectTemplate::all()->lists('name', 'id_project_template');;

        $project_tags = ProjectTag::all()->lists('name', 'id_tag');
        $production_line = ProductionLine::all()->lists('name', 'id_production_line');
        $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail(0)->get();
        return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line','production_order_detail']));

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
           $project->id_project_template=$request->id_project_template;
            $project->id_contact = $request->id_contact;
            $project->save();

        }
        session()->put('id_project',$id_project);
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
        session()->put('id_production_order',$production_order->id_production_order);
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
        $contacts  = Contact::all()->lists('name', 'id_contact');
      $templates = ProjectTemplate::all()->lists('name', 'id_project_template');
        $project_tags    = ProjectTag::all()->lists('name', 'id_tag');
        $production_line = ProductionLine::all()->lists('name', 'id_production_line');
      $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($production_order->id_production_order)->get();
        return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order','production_order_detail']));
      //  return redirect()->route('production_order.index');
    }

    public function storeOTExcel(Request $request)
    {
        //leer archivo
        $results = Excel::load($request->file, function ($reader) {

        })->get();

        foreach ($results as $key => $value) {
            //verificar si el estado es asignado para insertar
            if (strpos(strtolower(trim($value->estado)), 'asig')) {
                //buscar linea de produccion, si no existe crear
                $production_line = ProductionLine::where('name', $value->linea_trabajo)->first();

                if ($production_line != null) {

                    $id_production_line = $production_line->id_production_line;

                } else {

                    $id_production_line = $this->storePL($value->linea_trabajo);

                }
                //insertar cliente y contacto cliente es padre de contacto

                $client = Contact::where('code', $value->codcliente)->first();

                if (!$client) {

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
    public function edit($id,Request $request)
    {
        //if ($id!='0') {
          session()->put('id',$id);
          $production_order = ProductionOrder::findOrFail($id);
          //dd($production_order);
          $start_date = new Carbon($production_order->start_date_est);
          $end_date   = new Carbon($production_order->end_date_est);

          $production_order->start_date_est = $start_date->format('d/m/Y H:i');
          $production_order->end_date_est   = $end_date->format('d/m/Y H:i');

          $contacts  = Contact::all()->lists('name', 'id_contact');
        $templates = ProjectTemplate::all()->lists('name', 'id_project_template');
          $project_tags    = ProjectTag::all()->lists('name', 'id_tag');
          $production_line = ProductionLine::all()->lists('name', 'id_production_line');
        $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($id)->get();
          return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order','production_order_detail']));
      //  }
    //    else {

    //    $id=session()->get('id');
    //    $production_order = ProductionOrder::findOrFail($id);
        //dd($production_order);
    //    $start_date = new Carbon($production_order->start_date_est);
    //    $end_date   = new Carbon($production_order->end_date_est);

    //    $production_order->start_date_est = $start_date->format('d/m/Y H:i');
    //    $production_order->end_date_est   = $end_date->format('d/m/Y H:i');

    //    $contacts  = Contact::all()->lists('name', 'id_contact');
    //  $templates = ProjectTemplate::all()->lists('name', 'id_project_template');
    //    $project_tags    = ProjectTag::all()->lists('name', 'id_tag');
    //    $production_line = ProductionLine::all()->lists('name', 'id_production_line');
    //  $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($id)->get();

    //    return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order','production_order_detail']));
      //  }

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


        $range_date = explode("-", $request->range_date);

        $production_order = ProductionOrder::findOrFail($id);

        if ($production_order->id_project != "") {



            $project = Project::findOrFail($production_order->id_project );

            $project->id_contact = $request->id_contact;
               $project->id_project_template=$request->id_project_template;

            $project->save();

        }

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

        $production_orders = ProductionOrder::where('id_production_line', $id_line)->get();

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
    public function storeTemplate(Request $request)
    {





      if (isset($request))
      {
        if (isset($request->id_project_template))
        {
          $id_project=session()->get('id_project');
          $project=null;
           if (isset($id_project))
           {
          $project=Project::where('id_project','=',$id_project)->first();
          $project->id_project_template=$request->id_project_template;
          }
          $id_production_order=session()->get('id_production_order');
          $parent = ProjectTemplateDetail::where('parent_id_template_detail','=',null)->get();
          foreach ($parent as  $detail)
          {
                          $child = ProjectTemplateDetail::where('parent_id_template_detail','=',$detail->id_template_detail)->get();
                          if (isset($project))
                          {
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
                            $project_task->code                   =$detail->code;
                            $project_task->item_description       =$detail->item_description;
                            $project_task->quantity_est           =0;
                            $project_task->parent_id_project_task = null;
                            $project_task->save();
                          }

                            if (isset($id_production_order))
                            {
                          $production_order_detail                         = new ProductionOrderDetail;
                          $production_order_detail->id_production_order    = $id_production_order;
                          $production_order_detail->name                   = $detail->item_description;
                          $production_order_detail->quantity               =  0;
                          if (isset($project_task)) {
                          $production_order_detail->id_project_task        = $project_task->$id_project_task;
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
                          foreach ($child as  $detailchild)
                          {
                            if (isset($project))
                            {
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
                            $project_taskchild->code                   =$detail->code;
                            $project_taskchild->item_description       =$detail->item_description;
                            $project_taskchild->quantity_est           =0;
                            $project_taskchild->parent_id_project_task = $project_task->id_project_task;
                            $project_taskchild->save();
                           }

                            if (isset($id_production_order))
                            {
                            $production_order_detailchild                         = new ProductionOrderDetail;
                            $production_order_detailchild->id_production_order    = $id_production_order;
                            $production_order_detailchild->name                   = $detail->item_description;
                            $production_order_detailchild->quantity               =  0;
                            if (isset($project_taskchild)) {
                            $production_order_detailchild->id_project_task        = $project_taskchild->$id_project_task;
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
      $contacts  = Contact::all()->lists('name', 'id_contact');
      $templates = ProjectTemplate::all()->lists('name', 'id_project_template');
      $project_tags    = ProjectTag::all()->lists('name', 'id_tag');
      $production_line = ProductionLine::all()->lists('name', 'id_production_line');
      $production_order_detail = ProductionOrderDetail::GetProductionOrderDetail($id_production_order)->get();
      return view('Production/form_production_order', compact(['contacts', 'templates', 'project_tags', 'production_line', 'production_order','production_order_detail']));
    }

}
