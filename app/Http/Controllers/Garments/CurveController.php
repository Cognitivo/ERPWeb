<?php

namespace App\Http\Controllers\Garments;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;


class CurveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (file_exists(storage_path() . "/json/"))
      {
        $File=storage_path() . "/json/curve.json";
        $Json= json_decode(file_get_contents($File),true);

      }
      else {
        $Json=array();
      }


        return view('garments/curveindex',compact('Json'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $count=8;
        return view('garments/curveform',compact('count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if (!file_exists(storage_path() . "/json/"))
       {
        File::makeDirectory(storage_path() . "/json/");
        File::put(storage_path() . '/json/curve.json', '');
       }
       $item=array();
       foreach ($request->size as $key => $value) {
         if ($value!="") {
        array_push($item,$value);
         }

       }
        $File=storage_path() . "/json/curve.json";
        $data = array(

             "name"=>$request->name,
             "size"=>$item
        );
         $Json= array();
         if (json_decode(file_get_contents($File),true)!=null) {
              $Json = json_decode(file_get_contents($File),true);
         }

          array_push($Json,$data);

       file_put_contents($File,json_encode($Json));




        return view('garments/curveindex',compact('Json'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $File=storage_path() . "/json/curve.json";
        $name = array();
        $name = json_decode(file_get_contents($File),true);
        return view('garments/curveform',compact($name[0]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        $data = array();
        $count=0;
        $File=storage_path() . "/json/curve.json";
        $Json = array();
        $Json = json_decode(file_get_contents($File),true);
        $arraycount = count($Json);
        for($i=0;$i<$arraycount;$i++){
            $count=count($Json[$i]["size"]);

            if ($Json[$i]["name"]==$name) {
                $data=$Json[$i];

            }


        }



        return view('garments/curveform',compact('data','count','name'));
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

        $File=storage_path() . "/json/curve.json";
        $Json = array();
        $Json = json_decode(file_get_contents($File),true);
        $count = count($Json);
        for($i=0;$i<$count;$i++){
            if ($Json[$i]["name"]==$id) {
                $Json[$i]["name"]=$request->name;
                $Json[$i]["size"]=$request->size;
            }


        }

        file_put_contents($File,json_encode($Json));
        return view('garments/curveindex',compact('Json'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


    }



}
