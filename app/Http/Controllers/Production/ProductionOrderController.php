<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\ProductionOrder;
use App\Contact;
use App\ProjectTemplate;
use App\ProjectTag;
use App\Project;
use App\ProjectTask;
use App\ProductionLine;

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order= ProductionOrder::all();
        return view('Production/list_production_order',compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $contacts = Contact::all()->lists('name','id_contact');
        $templates = Project::whereNotNull('id_project_template')->select(DB::raw('name,concat(id_project,"-",id_project_template) as id_project_id_project_template'))->lists('name','id_project_id_project_template');
        $project_tags = ProjectTag::all()->lists('name','id_tag');

        $production_line = ProductionLine::all()->lists('name','id_production_line');
          
        return view('Production/form_production_order',compact(['contacts','templates','project_tags','production_line']));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $id_project = explode("-",$request->id_project_id_project_template)[0]; 

           $production_order = new  ProductionOrder;
           $production_order->id_production_line = $request->id_production_line;
           $production_order->id_project =  $id_project;
           


            $array = json_decode($request->tree_save);

        //dd($array);
        $array_result = collect();
        $array_parent = collect();
        $cont         = 0;
        //$parent = collect();
        foreach ($array as $key => $value) {
            //array_push($array_result,array('id'=>$value->id,'parentid'=>$value->parent,'name'=>$value->text));
            // $array_result->push();
            if ($value->parent == "#") {                
                $cont         = 0;
                $array_parent = collect();
                $id_real      = $this->insert_db($value->text, null, $project_template->getKey(), $value->data->id_item);
                $array_parent->push(['id' => $value->id, 'id_real' => $id_real]);
            } else {
                //dd($array_parent);
                
                //var_dump($array_parent);
                $parent = $array_parent->where('id', $value->parent)->first();
               
                if (count($parent)) {
                  
                    $parent_real = $parent['id_real'];                   
                    $id_real = $this->insert_db($value->text,$parent_real , $project_template->getKey(),$value->data->id_item);
                    $array_parent->push(['id' => $value->id, 'id_real' => $id_real]);
                    $cont++;
                   
                }

                //dd($array_parent);
            }

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
}
