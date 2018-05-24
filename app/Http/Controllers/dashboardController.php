<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Response;
use View;
use App\Security_User;
use Auth;
use File;
use Config;
use App\Http\Controllers\ComponentController;

class dashboardController extends Controller
{
    public function index(Request $request){

        $salespercustomer = DB::select('
        select contacts.name as contact,
        round(ifnull(sum(quantity * unit_price * vatco.coef),0),2) as sales
        from sales_invoice as si
        left join sales_invoice_detail as sd
        on si.id_sales_invoice = sd.id_sales_invoice
        left join(select app_vat_group.id_vat_group, sum(app_vat.coefficient) + 1 as coef
        from app_vat_group
        left join app_vat_group_details
        on app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
        left join app_vat
        on app_vat_group_details.id_vat = app_vat.id_vat
        group by app_vat_group.id_vat_group) as vatco
        on sd.id_vat_group = vatco.id_vat_group
        left join contacts
        on contacts.id_contact = si.id_contact
        group by  si.id_contact');

        $salespercustomer = collect($salespercustomer);

        $quantitypercustomer = DB::select('
        select contacts.name as contact,
        round(sum(quantity)) as quantity
        from sales_invoice as si
        left join sales_invoice_detail as sd
        on si.id_sales_invoice = sd.id_sales_invoice
        left join contacts
        on contacts.id_contact = si.id_contact
        group by  contacts.id_contact');

        $quantitypercustomer = collect($quantitypercustomer);

        $pendingreceivable = DB::select('
        select

        contact.name as Contact,
        round((schedual.debit - schedual.CreditChild),2) as Balance,
        DATE_FORMAT(schedual.expire_date, "%d/%m/%Y") as ExpireDate,
        ABS(DATEDIFF(schedual.expire_date,CURDATE())) as DelayDay,
        schedual.company as Company
        from (
            select
            parent.*,company.name as company,
            ( select if(sum(credit) is null, 0, sum(credit))
            from payment_schedual as child where child.parent_id_payment_schedual = parent.id_payment_schedual
            ) as CreditChild
            from payment_schedual as parent
            left join app_company as company
            on company.id_company = parent.id_company
            group by parent.id_payment_schedual
            ) as schedual

            inner join contacts as contact on schedual.id_contact = contact.id_contact
            inner join app_currencyfx as fx on schedual.id_currencyfx = fx.id_currencyfx
            inner join app_currency as curr on fx.id_currency = curr.id_currency
            inner join sales_invoice as si on schedual.id_sales_invoice = si.id_sales_invoice
            left join app_contract as contract on si.id_contract = contract.id_contract
            left join app_condition as cond on contract.id_condition = cond.id_condition
            where (schedual.debit - schedual.CreditChild) > 0
            and ABS(DATEDIFF(schedual.expire_date, CURDATE())) >0
            group by schedual.id_payment_schedual
            order by schedual.expire_date');

            $pendingreceivable = collect($pendingreceivable);
            return view('Dashboard.launch')
            ->with('quantitypercustomer',$quantitypercustomer)
            ->with('salespercustomer',$salespercustomer)
            ->with('pendingreceivable',$pendingreceivable);
        }

        public function SaveDashboard(Request $request)
        {
            $Name = Auth::user()->name;
            if (!file_exists(Config::get("Paths.UserDashboard") . $Name . "/")) {
                File::makeDirectory(Config::get("Paths.UserDashboard") . $Name . "/");
            }
            try
            {
                foreach (Input::get('components') as $Comp)
                {
                    $DashboardComponents[] = $Comp;
                }
                file_put_contents(Config::get("Paths.UserDashboard") . $Name . "/dashboard.json",json_encode($DashboardComponents));
            }
            catch(Exception $e)
            {
                return $e->getMessage();
            }

            return redirect('/');
        }

        public function ManageDashboard(){
            $Components = (new ComponentController)->ManageComponents();
            return view('Dashboard.ConfigComponents')->with('Components',$Components);
        }
    }
