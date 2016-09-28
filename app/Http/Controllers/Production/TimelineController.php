<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductionOrder;
use App\ProductionLine;
use Carbon\Carbon;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $production_order= new ProductionOrder;

        $production_order->name=$request->content;
        $production_order->start_date_est= $this->date_format($request->start);
        $production_order->end_date_est=$this->date_format($request->end);
        $production_order->id_production_line=$request->group;
        $production_order->id_company=1;
        $production_order->id_user= \Auth::user()->id_user;
        $production_order->trans_date=$this->date_format($request->start);
        $production_order->is_head=1;
        $production_order->timestamp;
        $production_order->id_branch=1;
        $production_order->id_terminal=1;
        $production_order->types=1;
        $production_order->is_read=1;

        $production_order->save();
     

         return response()->json(['id'=>$production_order->getKey()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       /* $timeline= \DB::table('production_line')->join('production_order','production_order.id_production_line','=','production_line.id_production_line')
        ->select('production_line.id_production_line',
            'production_line.name as name_line','start_date_est','end_date_est','production_order.name as  name_order')->get();*/

            $production_line= \DB::table('production_line')->select('production_line.id_production_line as id',
            'production_line.name as content')->get();

            $production_order= \DB::table('production_order')->select('id_production_order as id','name as content',\DB::raw('start_date_est as start'),\DB::raw('end_date_est as end'),'production_order.id_production_line as group')->get();

            $range_date = \DB::table('production_order')->select(\DB::raw('date(max(trans_date)) as maxi, date(min(trans_date)) as mini'))->get();           
            
            //dd($timeline);
        return response()->json(['production_order'=>$production_order,'production_line'=>$production_line,'range_date'=>$range_date]);


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
         
         //dd($id);
        //dd($this->date_format($request->end));

        $production_order =  ProductionOrder::find($id);
 
       $production_order->start_date_est= $this->date_format($request->start);
        $production_order->end_date_est = $this->date_format($request->end);
        $production_order->id_production_line= $request->group;

        $production_order->save();

        return response()->json(['id'=>$production_order->getKey()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $production_order= ProductionOrder::find($id);
        $production_order->delete();

        return response()->json(true);
    }

    public function date_format($date){

        return Carbon::createFromFormat('D M d Y H:i:s e+', $date)->toDateTimeString();
    }
}
