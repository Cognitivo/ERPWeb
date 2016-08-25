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
use App\ContactRole;
use App\Items;
use Carbon\Carbon;
use View;
use App\ContactTag;


class contactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

  $query=$request->input('q');

        $username = Session::get('username');

        $contacts =$query
        ? Contact::where('id_company', Auth::user()->id_company)->where('name','LIKE',"%$query%")
        ->orwhere('code','LIKE',"%$query%")
          ->orwhere('gov_code','LIKE',"%$query%")
         ->orderBy('name')->paginate(50)

         :Contact::where('id_company', Auth::user()->id_company)->orderBy('name')->paginate(50)
        ;


        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return View::make('commercial.contacts.index')
        ->with('contacts',$contacts)
        ->with('username',$username);

    }

    public function indexCustomers(Request $request)
    {

        $username = $request->session()->get('username');
        $contacts = Contact::where('is_customer', true)->where('id_company', Auth::user()->id_company)->orderBy('name')->paginate(200);

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/list/contact')->with('contacts',$contacts)->with('username',$username);
    }

    public function indexSuppliers(Request $request)
    {
        $username = $request->session()->get('username');
        $contacts = Contact::where('is_supplier', true)->where('id_company', Auth::user()->id_company)->orderBy('name')->paginate(200);

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
    //  $contacts= Contact::find($id);
      $contact_subscription = ContactSubsciption::where('id_contact', '=', $id)->paginate(200);

        $relation = Contact::where('parent_id_contact','=',$id)->get();

        $contactrole=ContactRole::where('id_company', Auth::user()->id_company)->lists('name','id_contact_role');
    //  dd($contact_subscription);
      //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
      return view('commercial/form/contact')
      //->with('contacts',$contacts)
      ->with('username',$username)
      ->with('contact_subscription',$contact_subscription)
        ->with('relation',$relation)
        ->with('contactrole',$contactrole);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $contact = new Contact;
      $contact->id_contact_role =$request->id_contact_role;
      $contact->id_company =Auth::user()->id_company;
      $contact->id_user =Auth::user()->id_user;
      $contact->name = $request->name;
      $contact->alias = $request->alias;
      $contact->code = $request->code;
      $contact->gov_code = $request->gov_code;
      $contact->telephone= $request->telephone;
      $contact->is_read = 0;
      $contact->is_head = 1;
      $contact->is_customer = 1;
      $contact->is_supplier = 0;
      $contact->is_employee = 0;
      $contact->is_sales_rep = 0;
      $contact->is_person = 0;

      $contact->timestamp = Carbon::now();
      $contact->is_active = 1;


      $contact->save();

      return redirect("contacts");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

      session(['idcontact'=>$id]);
      $username = $request->session()->get('username');
      $contacts = Contact::where('id_contact', $id)->first();

      //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
      return view('commercial/form/contact')
      ->with('contacts',$contacts)
      ->with('contact_subscription', $contact_subscription)

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


  session(['idcontact'=>$id]);
      $username = Session::get('username');
      //$contacts = Contact::where('id_contact', $id)->get();
      $contacts= Contact::find($id);

      $contact_subscription = ContactSubsciption::where('id_contact', '=', $id)->get();
          $contact_tag = ContactTag::where('id_contact', '=', $id)->get();
        $relation = Contact::where('parent_id_contact','=',$id)->get();
          $contactrole=ContactRole::where('id_company', Auth::user()->id_company)->lists('name','id_contact_role');
    //  dd($contact_subscription);
      //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
      return view('commercial/form/contact')
      ->with('contacts',$contacts)
      ->with('username',$username)
      ->with('contact_subscription',$contact_subscription)
        ->with('contact_tag', $contact_tag)
        ->with('relation',$relation)
          ->with('contactrole',$contactrole);
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

      $contacts= Contact::findOrFail($id);
      $contacts->fill($request->all());

      $contacts->save();

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
    public function get(Request $request)
    {
      dd(Request::get('q'));
      $query=Request::get('q');
          $contacts=$query?Contact::where('name','LIKE',"%$query%")->get():Contact::all();
    }
}
