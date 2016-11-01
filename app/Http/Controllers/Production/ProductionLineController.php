<?php

namespace App\Http\Controllers\Production;

use App\AppLocation;
use App\Http\Controllers\Controller;
use App\ProductionLine;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductionLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $line = ProductionLine::all();
        return view('Production/list_production_line', compact('line'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $applocation = AppLocation::where('id_company', Auth::user()->id_company)->lists('name', 'id_location');

        return view('Production/form_production_line', compact('applocation'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ProductionLine              = new ProductionLine;
        $ProductionLine->id_company  = Auth::user()->id_company;
        $ProductionLine->id_user     = Auth::user()->id_user;
        $ProductionLine->is_read     = 0;
        $ProductionLine->is_head     = 1;
        $ProductionLine->name        = $request->name;
        $ProductionLine->timestamp   = Carbon::now();
        $ProductionLine->id_location = $request->id_location;
        $ProductionLine->save();
        $line = ProductionLine::all();
        return view('Production/list_production_line', compact('line'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $line = ProductionLine::all();

        return view('Production/list_production_line', compact('line'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $line = ProductionLine::find($id);

        $applocation = AppLocation::where('id_company', Auth::user()->id_company)->lists('name', 'id_location');
        
        return view('Production/form_production_line', compact('line', 'applocation'));
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
        $ProductionLine              = ProductionLine::find($id);
        $ProductionLine->name        = $request->name;
        $ProductionLine->id_location = $request->id_location;
        $ProductionLine->save();
        $line = ProductionLine::all();
        return view('Production/list_production_line', compact('line'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ProductionLine = ProductionLine::find($id);

        try
        {

            $ProductionLine->delete();

              flash('Operación realizada con éxito','success');

            return redirect()->back();

        } catch (\Illuminate\Database\QueryException $e) {

            flash('No se puede eliminar!','danger');

            return redirect()->back();

        }

    }
}
