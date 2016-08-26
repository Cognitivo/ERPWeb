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
use App\ContactSubsciption;
use App\Items;
use App\Tag;
use App\ContactTag;
use Carbon\Carbon;

class contactstagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $username = Session::get('username');

        $contacts = Contact::where('id_company', Auth::user()->id_company)->orderBy('name')->Paginate(10000);

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/list/contact')
        ->with('contacts',$contacts)
        ->with('username',$username);

    }

    public function indexCustomers(Request $request)
    {
        $username = $request->session()->get('username');
        $contacts = Contact::where('is_customer', true)->where('id_company', Auth::user()->id_company)->orderBy('name')->simplePaginate(10000);

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/list/contact')->with('contacts',$contacts)->with('username',$username);
    }

    public function indexSuppliers(Request $request)
    {
        $username = $request->session()->get('username');
        $contacts = Contact::where('is_supplier', true)->where('id_company', Auth::user()->id_company)->orderBy('name')->simplePaginate(10000);

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/list/contact')->with('contacts',$contacts)->with('username',$username);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $id=0;
      $username = Session::get('username');
      //$contacts = Contact::where('id_contact', $id)->get();
      $contacts= Contact::find($id);
      $contact_subscription = ContactSubsciption::where('id_contact', '=', $id)->simplepaginate(10000);
      //  $relation = Contact::where('parent_id_contact','=',$id)->get();
        $tag=Tag::where('id_company', Auth::user()->id_company)->lists('name','id_tag');
    //  dd($contact_subscription);
      //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
      return view('commercial/form/tag')
      ->with('contacts',$contacts)
      ->with('username',$username)
        ->with('contact_subscription',$contact_subscription)
      //  ->with('relation',$relation)
        ->with('tag',$tag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $idcontact = Session::get('idcontact');

      $tag = new ContactTag;

    $tag->id_contact=$idcontact;
      $tag->id_tag=$request->id_tag;

      $tag->id_company =Auth::user()->id_company;

      $tag->id_user =Auth::user()->id_user;



      $tag->is_read = 0;
      $tag->is_head = 1;

      $tag->timestamp = Carbon::now();



      $tag->save();

      return redirect()->action('Commercial\contactsController@edit', [$idcontact]);
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
      return view('commercial/form/contact')
      ->with('contacts',$contacts)
        ->with('username',$username);
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

      $username = Session::get('username');
      //$contacts = Contact::where('id_contact', $id)->get();
      $contacts= Contact::find($id);
      $contact_tag = ContactTag::where('id_contact', $id)->all();
    //  dd($contact_subscription);
      //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
      return view('commercial/form/tag')
      ->with('contacts',$contacts)
      ->with('username',$username)
      ->with('contact_tag',$contact_tag);
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
        // dd($id);


              $contact_tag= ContactTag::findOrFail($id);
              $contact_tag->fill($request->all());

              $contact_tag->save();


      return redirect('contacts');

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
