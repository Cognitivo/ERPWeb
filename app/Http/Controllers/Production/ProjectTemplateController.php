<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Project;
use App\ProjectTemplate;
use App\ProjectTemplateDetail;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use App\ProductionOrderDetail;

class ProjectTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = \DB::table('project_template')->get();
        return view('Production/list_project_template')->with('template', $template);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Production/form_project_template');
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
           //dd(json_decode($request->tree_save));
        //save template
        $project_template                 = new ProjectTemplate;
        $project_template->name           = $request->name;
        $project_template->id_item_output = 1;
        $project_template->id_company     = 1;
        $project_template->id_user        = 1;
        $project_template->is_active      = 1;
        $project_template->is_head        = 1;
        $project_template->is_read        = 1;
        $project_template->timestamp      = Carbon::now();
        $project_template->save();

        //save project
        $project                      = new Project;
        $project->id_project_template = $project_template->getKey();
        $project->name                = $request->name;
        $project->priority            = 1;
        $project->id_company          = 1;
        $project->id_user             = 1;
        $project->is_active           = 1;
        $project->is_head             = 1;
        $project->is_read             = 1;
        $project->timestamp           = Carbon::now();
        $project->save();

        //save project_template_detail
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
       // dd("ok");
        return redirect()->route('project_template.index');
        // dd($array_parent);

        //$tree = $this->createTree($array_result);
        // dd($tree);

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

        $template = ProjectTemplate::find($id);

        return view('Production/form_project_template')->with('template', $template);
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

       

    /*    if ($request->production_order) {
            $template_detail        = ProjectTemplateDetail::find($id);
            $array_split_name_value = explode("\t", $request->text);

            $template_detail->item_description = $array_split_name_value[0];

            //$template_detail->unit_value = count($array_split_name_value) > 1 ? $array_split_name_value[1] : 0;

            $template_detail->save();

            return response()->json(true);
        }*/
        
        $template = ProjectTemplate::find($id);
        $template->name = $request->name;
        $template->save();

        $array = json_decode($request->tree_save);

        //dd($array);
        $array_result = collect();
        $array_parent = collect();
        $cont         = 0;
        foreach ($array as $key => $value) {
            //array_push($array_result,array('id'=>$value->id,'parentid'=>$value->parent,'name'=>$value->text));
            // $array_result->push();
            if ($value->parent == "#") {
                $cont         = 0;
                $array_parent = collect();
                if (!$this->exist($value->id)) {
                    $id_real = $this->insert_db($value->text, null, $id, $value->data->id_item);

                } else {
                    $id_real = $this->update_db($value->text, $value->id, $value->data->id_item); //to do
                }
                $array_parent->push(['id' => $value->id, 'id_real' => $value->id]);
            } else {
                //dd($array_parent);
                /*   if(!$this->exist_parent($value->parent)){
                $parent = $array_parent->where('id', $value->parent);
                }else{
                $parent = $array_parent->where('id', $value->parent);
                }*/

                $parent = $array_parent->where('id', $value->parent)->first();

                if (count($parent)) {
                    if (!$this->exist($value->id)) {
                        //dd($parent);
                        $id_real = $this->insert_db($value->text, $parent['id_real'], $id, $value->data->id_item);

                    } else {
                        $id_real = $this->update_db($value->text, $value->id, $value->data->id_item); //to do
                    }
                    $array_parent->push(['id' => $value->id, 'id_real' => $value->id]);
                    $cont++;
                }

                //dd($array_parent);
            }

        }
        return redirect()->route('project_template.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = ProjectTemplateDetail::where('id_template_detail', $id);

        if ($detail->get()->count()) {
            $detail->delete();
            return "ok";
        } else {
            return null;
        }

    }

    public function load_tree(Request $request,$id_template,$id_project)
    {
         if(isset($request->id_production_order)){
            $data = ProductionOrderDetail::join('items', 'items.id_item', '=', 'production_order_detail.id_item')
            ->where('id_production_order',$request->id_production_order)->select('id_order_detail as id','parent_id_order_detail as parent',DB::raw('concat(production_order_detail.name,"\t",quantity) as text'),'production_order_detail.id_item as data', 'id_item_type as type')->get();
         }else{
            $data = ProjectTemplateDetail::join('items', 'items.id_item', '=', 'project_template_detail.id_item')
            ->where('id_project_template', $id_template)
            ->select('id_template_detail as id', 'parent_id_template_detail as parent', DB::raw('concat(item_description,"\t",0) as text') , 'project_template_detail.id_item as data', 'id_item_type as type')->get();

         }

        
        //dd(json_decode($data));
        foreach ($data as $item) {
            if ($item->parent == null) {
                $item->parent = "#";
            }
            $item->data = ['id_item' => $item->data];
            if ($item->type != 5) {
                $item->type = "file";
            } else {
                $item->type = "default";
            }
        }

        //dd(json_decode($data));
        return $data;

    }

    // methods aux
    public function split($value)
    {
        return explode("\t", $value);
    }

    public function insert_db($name, $parent, $id_project, $item)
    {

        //$array_aux = $this->split($name);

        $project_template_detail                            = new ProjectTemplateDetail;
        $project_template_detail->parent_id_template_detail = $parent;
        $project_template_detail->id_project_template       = $id_project;
        $project_template_detail->id_company                = 1;
        $project_template_detail->id_user                   = 1;
        //$project_template_detail->unit_value                = $array_aux[1];
        $project_template_detail->item_description = $name;
        $project_template_detail->is_head          = 1;
        $project_template_detail->is_read          = 1;
        $project_template_detail->timestamp        = Carbon::now();
        $project_template_detail->id_item          = $item;
        $project_template_detail->save();

        return $project_template_detail->getKey();

    }

    public function update_db($name, $id, $id_item)
    {
        $array_aux = $this->split($name);
        //dd(count($array_aux));

        $project_template_detail = ProjectTemplateDetail::findOrFail($id);
        //$project_template_detail->unit_value       = count($array_aux) > 1 ? $array_aux[1] : 0;
        $project_template_detail->item_description = $array_aux[0];
        $project_template_detail->id_item          = $id_item;
        $project_template_detail->save();
    }

    public function exist($id)
    {

        $detail = ProjectTemplateDetail::where('id_template_detail', $id)->get();

        return $detail->count() ? true : false;
    }

    public function exist_parent($id)
    {

        $detail = ProjectTemplateDetail::where('parent_id_template_detail', $id)->get();

        return $detail->count() ? true : false;
    }

    /* Recursive branch extrusion */
/*     public function createBranch(&$parents, $children)
{
$tree = array();
foreach ($children as $child) {
if (isset($parents[$child['id']])) {
$child['children'] =
$this->createBranch($parents, $parents[$child['id']]);
}
$tree[] = $child;
}
return $tree;
}
 */
/* Initialization */
    /* public function createTree($flat, $root = '#')
{
$parents = array();
foreach ($flat as $a) {
$parents[$a['parentid']][] = $a;
}
return $this->createBranch($parents, $parents[$root]);
}*/
}
