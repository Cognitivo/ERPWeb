<?php

namespace App\Http\Controllers\Garments;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $File=storage_path() . "/json/curve.json";
        $Json= json_decode(file_get_contents($File),true);


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
        return view('garments/curveform',compact($count));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $File=storage_path() . "/json/curve.json";
        $Json = array();

        $data = array(

             "name"=>$request->name,
            "size"=>$request->size
        );
        $Json = json_decode(file_get_contents($File),true);
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
        $File=storage_path() . "/json/curve.json";
        $Json = array();
        $Json = json_decode(file_get_contents($File),true);
        $arraycount = count($Json);
        $data = array();
        $count=0;
        for($i=0;$i<$arraycount;$i++){
            $count=count($Json[$i]["name"]);
            if ($Json[$i]["name"]==$name) {
                $data=$Json[$i];
            }


        }

        return view('garments/curveform',compact('data'));
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
