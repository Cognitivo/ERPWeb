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
    public function showdetail($id)
    {
        $ProductionOrderDetail = ProductionOrderDetail::findOrFail($id);


        return response()->json($ProductionOrderDetail);
    }


}
