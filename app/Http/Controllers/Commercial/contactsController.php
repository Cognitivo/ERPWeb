<?php

namespace App\Http\Controllers\Commercial;


use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Validator;
use Session;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Routing\Route;
use Auth;
use App\Subcription;
use App\Contact;

class contactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $username = $request->session()->get('username');

        $contacts = Contact::where('id_company', Auth::user()->id_company)->get();

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/list/contactlist')->with('contacts',$contacts)->with('username',$username);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
      $username = $request->session()->get('username');
      $contacts = Contact::where('id_contact', $id)->first();

      //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
      return view('commercial/form/contact')->with('contacts',$contacts)->with('username',$username);
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
