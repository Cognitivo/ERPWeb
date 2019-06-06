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

        // $pendingreceivable = DB::select('
        // select

        // contact.name as Contact,
        // round((schedual.debit - schedual.CreditChild),2) as Balance,
        // DATE_FORMAT(schedual.expire_date, "%d/%m/%Y") as ExpireDate,
        // ABS(DATEDIFF(schedual.expire_date,CURDATE())) as DelayDay,
        // schedual.company as Company
        // from (
        //     select
        //     parent.*,company.name as company,
        //     ( select if(sum(credit) is null, 0, sum(credit))
        //     from payment_schedual as child where child.parent_id_payment_schedual = parent.id_payment_schedual
        //     ) as CreditChild
        //     from payment_schedual as parent
        //     left join app_company as company
        //     on company.id_company = parent.id_company
        //     group by parent.id_payment_schedual
        //     ) as schedual

        //     inner join contacts as contact on schedual.id_contact = contact.id_contact
        //     inner join app_currencyfx as fx on schedual.id_currencyfx = fx.id_currencyfx
        //     inner join app_currency as curr on fx.id_currency = curr.id_currency
        //     inner join sales_invoice as si on schedual.id_sales_invoice = si.id_sales_invoice
        //     left join app_contract as contract on si.id_contract = contract.id_contract
        //     left join app_condition as cond on contract.id_condition = cond.id_condition
        //     where (schedual.debit - schedual.CreditChild) > 0
        //     and ABS(DATEDIFF(schedual.expire_date, CURDATE())) >0
        //     group by schedual.id_payment_schedual
        //     order by schedual.expire_date');

        //   $pendingreceivable = DB::select('
        //   select
        //   contact.name as Contact,
        //   DATE_FORMAT(schedual.expire_date, "%M") as month,
        //   app_branch.name as Branch,
        //   round((schedual.debit - schedual.CreditChild),2) as Balance,
        //   DATE_FORMAT(schedual.expire_date, "%d/%m/%Y") as ExpireDate,
        //   ABS(DATEDIFF(schedual.expire_date,CURDATE())) as DelayDay,
        //   schedual.company as Company
        //   from (
        //       select
        //       parent.*,company.name as company,
        //       ( select if(sum(credit) is null, 0, sum(credit))
        //       from payment_schedual as child where child.parent_id_payment_schedual = parent.id_payment_schedual
        //       ) as CreditChild
        //       from payment_schedual as parent
        //       left join app_company as company
        //       on company.id_company = parent.id_company
        //       group by parent.id_payment_schedual
        //       ) as schedual
  
        //       inner join contacts as contact on schedual.id_contact = contact.id_contact
        //       inner join app_currencyfx as fx on schedual.id_currencyfx = fx.id_currencyfx
        //       inner join app_currency as curr on fx.id_currency = curr.id_currency
        //       inner join sales_invoice as si on schedual.id_sales_invoice = si.id_sales_invoice
        //       inner join app_branch on app_branch.id_branch = si.id_branch
        //       left join app_contract as contract on si.id_contract = contract.id_contract
        //       left join app_condition as cond on contract.id_condition = cond.id_condition
        //       where (schedual.debit - schedual.CreditChild) > 0
        //       and ABS(DATEDIFF(schedual.expire_date, CURDATE())) >0
        //       group by contact.id_contact
        //       order by schedual.expire_date');

        //     $pendingreceivable = collect($pendingreceivable);


            
        $salesitem = DB::select('
            SELECT sales_invoice_detail.id_sales_invoice ,contacts.name, item_description, quantity FROM sales_invoice_detail
            join sales_invoice on sales_invoice.id_sales_invoice = sales_invoice_detail.id_sales_invoice
            join contacts on contacts.id_contact = sales_invoice.id_contact
            where  status=2 order by contacts.name');

            $salesitem = collect($salesitem);

            $salesmargin = DB::select('
            select sales_invoice.number as Number,items.code as Code,items.name as Items,quantity as Quantity,sales_invoice_detail.unit_price as UnitPrice,
            round((sales_invoice_detail.quantity * sales_invoice_detail.unit_price * vatco.coef),4) as SubTotalVat,round(sales_invoice_detail.discount, 4) as Discount,
            (sales_invoice_detail.unit_price - sales_invoice_detail.unit_cost) / (sales_invoice_detail.unit_price) as Margin,
            (sales_invoice_detail.unit_price - sales_invoice_detail.unit_cost) / (sales_invoice_detail.unit_cost) as MarkUp,
            (sales_invoice_detail.unit_price - sales_invoice_detail.unit_cost) as Profit
            from sales_invoice_detail inner join sales_invoice on sales_invoice_detail.id_sales_invoice=sales_invoice.id_sales_invoice
            inner join items on sales_invoice_detail.id_item = items.id_item
            LEFT OUTER JOIN
                         (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                            FROM  app_vat_group
                                LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                                LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                            GROUP BY app_vat_group.id_vat_group)
                            vatco ON vatco.id_vat_group = sales_invoice_detail.id_vat_group
            order by sales_invoice.trans_date');

            $salesmargin = collect($salesmargin);




            return view('Dashboard.launch')
            ->with('quantitypercustomer',$quantitypercustomer)
            ->with('salespercustomer',$salespercustomer)
            //->with('pendingreceivable',$pendingreceivable)
            ->with('salesitem',$salesitem)
            ->with('salesmargin',$salesmargin);
        }
        public function PendingReceivable(Request $request)
        {
        
              $pendingreceivable = DB::select('
              select Contact, sum(January) as January,sum(February) as February,sum(March) as March,sum(April) as April,sum(May) as May,sum(June) as June,
sum(July) as July,sum(August) as August,sum(September) as September,sum(Octomber) as Octomber,sum(November) as November ,sum(December) as December from (select
schedual.company as Company,
  contact.id_contact,
   contact.name as Contact,
    (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="January" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0 
        END) as January,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="February" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as February,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="March" 
            THEN  round((schedual.debit - schedual.CreditChild),2) 
            ELSE 0  
        END) as March,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="April" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as April,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="May" 
            THEN  round((schedual.debit - schedual.CreditChild),2)
            ELSE 0  
        END) as May,
        
      (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="June" 
            THEN sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as June,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="July" 
            THEN sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as July,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="August" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as August,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="September" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as September,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="Octomber" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as Octomber,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="November" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as November,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, "%M")="December" 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as December
        
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
              group by schedual.company,contact.id_contact,DATE_FORMAT(schedual.expire_date, "%M")
              order by contact.id_contact, schedual.company) as j group by id_contact');
    
                $pendingreceivable = collect($pendingreceivable);
    
                  
              
                return view('Dashboard.PendingReceivableReport')
                ->with('pendingreceivable',$pendingreceivable);
              
            }

            public function SalesMargin(Request $request)
        {
        
            $salesmargin = DB::select('
            select sales_invoice.number as Number,items.code as Code,items.name as Items,quantity as Quantity,sales_invoice_detail.unit_price as UnitPrice,
            round((sales_invoice_detail.quantity * sales_invoice_detail.unit_price * vatco.coef),4) as SubTotalVat,round(sales_invoice_detail.discount, 4) as Discount,
            (sales_invoice_detail.unit_price - sales_invoice_detail.unit_cost) / (sales_invoice_detail.unit_price) as Margin,
            (sales_invoice_detail.unit_price - sales_invoice_detail.unit_cost) / (sales_invoice_detail.unit_cost) as MarkUp,
            (sales_invoice_detail.unit_price - sales_invoice_detail.unit_cost) as Profit
            from sales_invoice_detail inner join sales_invoice on sales_invoice_detail.id_sales_invoice=sales_invoice.id_sales_invoice
            inner join items on sales_invoice_detail.id_item = items.id_item
            LEFT OUTER JOIN
                         (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                            FROM  app_vat_group
                                LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                                LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                            GROUP BY app_vat_group.id_vat_group)
                            vatco ON vatco.id_vat_group = sales_invoice_detail.id_vat_group
            order by sales_invoice.trans_date');

            $salesmargin = collect($salesmargin);
                  
              
                return view('Dashboard.SalesMarginReport')
                ->with('salesmargin',$salesmargin);
              
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

    
