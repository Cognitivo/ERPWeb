<?php
namespace App\Http\Controllers\Commercial;

use App\Contact;
use App\ContactRole;
use App\ContactSubsciption;
use App\ContactTag;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use View;

use App\ContactField;

class contactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = $request->input('q');

        $username = Session::get('username');

        $contacts = $query
        ? Contact::where('id_company', Auth::user()->id_company)->where('name', 'LIKE', "%$query%")
            ->orwhere('code', 'LIKE', "%$query%")
            ->orwhere('gov_code', 'LIKE', "%$query%")
            ->orderBy('name')->paginate(50)

        : Contact::where('id_company', Auth::user()->id_company)->orderBy('name')->paginate(50)
        ;

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return View::make('commercial.contacts.index')
            ->with('contacts', $contacts)
            ->with('username', $username);

    }

    public function indexCustomers(Request $request)
    {

        $username = $request->session()->get('username');
        $contacts = Contact::where('is_customer', true)->where('id_company', Auth::user()->id_company)->orderBy('name')->paginate(200);

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/list/contact')->with('contacts', $contacts)->with('username', $username);
    }

    public function indexSuppliers(Request $request)
    {
        $username = $request->session()->get('username');
        $contacts = Contact::where('is_supplier', true)->where('id_company', Auth::user()->id_company)->orderBy('name')->paginate(200);

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/list/contact')->with('contacts', $contacts)->with('username', $username);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = 0;

        $username = Session::get('username');
        //$contacts = Contact::where('id_contact', $id)->get();
        //  $contacts= Contact::find($id);
        $contact_subscription = ContactSubsciption::where('id_contact', '=', $id)->paginate(200);

        $relation    = Contact::where('parent_id_contact', '=', $id)->get();
        $contact_tag = ContactTag::where('id_contact', '=', $id)->get();
        $contactrole = ContactRole::where('id_company', Auth::user()->id_company)->lists('name', 'id_contact_role');

        $contract   = \DB::table('app_contract')->lists('name', 'id_contract');
        $currency   = \DB::table('app_currency')->lists('name', 'id_currency');
        $bank       = \DB::table('app_bank')->lists('name', 'id_bank');
        $price_list = \DB::table('item_price_list')->lists('name', 'id_price_list');
        $sales_rep  = \DB::table('sales_rep')->lists('name', 'id_sales_rep');

        $account = \DB::table('app_field')->lists('name', 'id_field');

        //  dd($contact_subscription);
        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/form/contact')
        //->with('contacts',$contacts)
        ->with('username', $username)
            ->with('contact_subscription', $contact_subscription)
            ->with('relation', $relation)
            ->with('contact_tag', $contact_tag)
            ->with('contactrole', $contactrole)

            ->with(['contract' => $contract, 'currency' => $currency, 'bank' => $bank, 'price_list' => $price_list, 'sales_rep' => $sales_rep, 'account' => $account]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact                  = new Contact;
        $contact->id_contact_role = $request->id_contact_role;
        $contact->id_company      = Auth::user()->id_company;
        $contact->id_user         = Auth::user()->id_user;
        $contact->name            = $request->name;
        $contact->alias           = $request->alias;
        $contact->code            = $request->code;
        $contact->gov_code        = $request->gov_code;
        $contact->telephone       = $request->telephone;
        $contact->is_read         = 0;
        $contact->is_head         = 1;
        $contact->is_customer     = 1;
        $contact->is_supplier     = 0;
        $contact->is_employee     = 0;
        $contact->is_sales_rep    = 0;
        $contact->address         = $request->address;
        $contact->is_person       = $request->is_person ? 1 : 0;

        $contact->timestamp = Carbon::now();
        $contact->is_active = 1;

        $contact->save();
        session(['idcontact' => $contact->getKey()]);
        return redirect()->action('Commercial\contactsController@edit', [Session::get('idcontact')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        session(['idcontact' => $id]);
        $username = $request->session()->get('username');
        $contacts = Contact::where('id_contact', $id)->first();

        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/form/contact')
            ->with('contacts', $contacts)
            ->with('contact_subscription', $contact_subscription)

            ->with('username', $username);
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

        session(['idcontact' => $id]);
        $username = Session::get('username');
        //$contacts = Contact::where('id_contact', $id)->get();
        $contacts = Contact::find($id);

        $contact_subscription = ContactSubsciption::where('id_contact', '=', $id)->get();

        $contact_tag = ContactTag::where('id_contact', '=', $id)->get();
        $relation    = Contact::where('parent_id_contact', '=', $id)->get();
        $contactrole = ContactRole::where('id_company', Auth::user()->id_company)->lists('name', 'id_contact_role');
        //  dd($contact_subscription);
        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();

        $contract   = \DB::table('app_contract')->lists('name', 'id_contract');
        $currency   = \DB::table('app_currency')->lists('name', 'id_currency');
        $bank       = \DB::table('app_bank')->lists('name', 'id_bank');
        $price_list = \DB::table('item_price_list')->lists('name', 'id_price_list');
        $sales_rep  = \DB::table('sales_rep')->lists('name', 'id_sales_rep');
        $account    = \DB::table('app_field')->lists('name', 'id_field');

        foreach ($relation as $key => $value) {
            $subscription_aux     = ContactSubsciption::where('id_contact', '=', $value->id_contact)->get();
            $aux                  = $contact_subscription->merge($subscription_aux);
            $contact_subscription = $aux;
        }

        //dd($contact_subscription[0]->Contacts->name);

        return view('commercial/form/contact')
            ->with('contacts', $contacts)
            ->with('username', $username)
            ->with('contact_subscription', $contact_subscription)
            ->with('contact_tag', $contact_tag)
            ->with('relation', $relation)
            ->with('contactrole', $contactrole)
            ->with(['contract' => $contract, 'currency' => $currency, 'bank' => $bank, 'price_list' => $price_list, 'sales_rep' => $sales_rep, 'account' => $account]);
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
        $contacts = Contact::findOrFail($id);
        $contacts->fill($request->all());

        if ($request->is_person) {
            $contacts->is_person = 1;
        } else {
            $contacts->is_person = 0;
        }

        //Finance
        if ($request->is_finance == 1) {
            if ($request->is_customer) {
                $contacts->is_customer = 1;
            } else {
                $contacts->is_customer = 0;
            }

            if ($request->is_supplier_id) {
                $contacts->is_supplier=1;
            } else {
                $contacts->is_supplier = 0;
            }

            $contacts->id_bank      = $request->id_bank;
            $contacts->id_currency  = $request->id_currency;
            $contacts->id_contract  = $request->id_contract;
            $contacts->id_sales_rep = $request->id_sales_rep;

        }

        $contacts->save();

        if($request->is_finance==1){
          $contact_field_value= new  ContactField;
          $contact_field_value->id_company= $contacts->id_company;
          $contact_field_value->id_user= $contacts->id_user;
          $contact_field_value->is_head=1;
          $contact_field_value->id_contact = $contacts->id_contact; 
          $contact_field_value->id_field = $request->id_field;
          $contact_field_value->value = $request->account_value;
          $contact_field_value->save();         
          
        }

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

        $query    = Request::get('q');
        $contacts = $query ? Contact::where('name', 'LIKE', "%$query%")->get() : Contact::all();
    }
}
