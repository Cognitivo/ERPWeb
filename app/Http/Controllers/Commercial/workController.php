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


// krunal Start
class workController extends Controller {
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
    public function create()
    {
        $id = 0;

        $username = Session::get('username');
        //$contacts = Contact::where('id_contact', $id)->get();
        //  $contacts= Contact::find($id);
        $contact_subscription = ContactSubsciption::where('id_contact', '=', $id)->paginate(200);



        $relation    = Contact::where('parent_id_contact', '=', $id)->get();
        $contact_tag = ContactTag::where('id_contact', '=', $id)->get();
        $contactrole = ContactRole::where('id_company', Auth::user()->id_company)->where('is_active',1)->lists('name', 'id_contact_role');

        $contract   = \DB::table('app_contract')->lists('name', 'id_contract');
        $currency   = \DB::table('app_currency')->lists('name', 'id_currency');
        $bank       = \DB::table('app_bank')->lists('name', 'id_bank');
        $price_list = \DB::table('item_price_list')->lists('name', 'id_price_list');
        $sales_rep  = \DB::table('sales_rep')->lists('name', 'id_sales_rep');

        $account = \DB::table('app_field')->lists('name', 'id_field');

        //  dd($contact_subscription);
        //$usuarios= User::buscar($palabra)->orderBy('id','DESC')->get();
        return view('commercial/form/work')
        //->with('contacts',$contacts)
        ->with('username', $username)
            ->with('contact_subscription', $contact_subscription)
            ->with('relation', $relation)
            ->with('contact_tag', $contact_tag)
            ->with('contactrole', $contactrole)

            ->with(['contract' => $contract, 'currency' => $currency, 'bank' => $bank, 'price_list' => $price_list, 'sales_rep' => $sales_rep, 'account' => $account]);

    }
  }
