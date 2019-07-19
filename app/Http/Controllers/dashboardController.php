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
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\ComponentController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\View2Excel;

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
          $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }

              $pendingreceivable = DB::select("
              select Contact,Company, sum(January) as January,sum(February) as February,sum(March) as March,sum(April) as April,sum(May) as May,sum(June) as June,
sum(July) as July,sum(August) as August,sum(September) as September,sum(Octomber) as Octomber,sum(November) as November ,sum(December) as December from (select
schedual.company as Company,
  contact.id_contact,
   contact.name as Contact,
    (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='January' 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0 
        END) as January,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='February'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as February,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='March'
            THEN  round((schedual.debit - schedual.CreditChild),2) 
            ELSE 0  
        END) as March,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='April'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as April,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='May'
            THEN  round((schedual.debit - schedual.CreditChild),2)
            ELSE 0  
        END) as May,
        
      (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='June'
            THEN sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as June,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='July'
            THEN sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as July,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='August'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as August,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='September'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as September,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='Octomber'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as Octomber,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='November'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as November,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='December'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as December
        
          from (
              select
              parent.*,company.alias as company,
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
              and schedual.trans_date >= '" . $startDate . "' and schedual.trans_date <= '" . $endDate . "' 
              group by schedual.company,contact.id_contact,DATE_FORMAT(schedual.expire_date, '%M')
              order by contact.id_contact, schedual.company) as j group by id_contact");
    
                $pendingreceivable = collect($pendingreceivable);
              
                return view('Dashboard.PendingReceivableReport')
                ->with('pendingreceivable',$pendingreceivable);
            
            }

             public function ExportPendingReceivable(Request $request)
        {
          $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }

              $pendingreceivable = DB::select("
              select Contact as Cliente,Company, sum(January) as January,sum(February) as February,sum(March) as March,sum(April) as April,sum(May) as May,sum(June) as June,
sum(July) as July,sum(August) as August,sum(September) as September,sum(Octomber) as Octomber,sum(November) as November ,sum(December) as December

from (select
schedual.company as Company,
  contact.id_contact,
   contact.name as Contact,
    (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='January' 
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0 
        END) as January,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='February'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as February,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='March'
            THEN  round((schedual.debit - schedual.CreditChild),2) 
            ELSE 0  
        END) as March,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='April'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as April,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='May'
            THEN  round((schedual.debit - schedual.CreditChild),2)
            ELSE 0  
        END) as May,
        
      (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='June'
            THEN sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as June,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='July'
            THEN sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as July,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='August'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as August,
         (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='September'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as September,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='Octomber'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as Octomber,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='November'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as November,
        (CASE 
            WHEN  DATE_FORMAT(schedual.expire_date, '%M')='December'
            THEN  sum(round((schedual.debit - schedual.CreditChild),2) )
            ELSE 0  
        END) as December
        
          from (
              select
              parent.*,company.alias as company,
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
              and schedual.trans_date >= '" . $startDate . "' and schedual.trans_date <= '" . $endDate . "' 
              group by schedual.company,contact.id_contact,DATE_FORMAT(schedual.expire_date, '%M')
              order by contact.id_contact, schedual.company) as j group by id_contact");
    
                $pendingreceivable = collect($pendingreceivable);
                $data = json_decode( json_encode($pendingreceivable), true);

                  return Excel::create("Pending Receivables" . '|' . $startDate . '-' . $endDate, function($excel) 
                  use($pendingreceivable) {
                        foreach ($pendingreceivable->groupBy('Company') as $groupedByCompany)
                        {
                           $company = json_decode( json_encode($groupedByCompany), true);
                          
                             $excel->sheet($groupedByCompany->first()->Company, function($sheet) use ($company)
                                    {
                                        $sheet->fromArray($company);
                            });
                        }
                  })->download('xls');
                
               
            
            }
           public function SalesByClientQuery( $startDate, $endDate)
           {
                    $salesData = DB::select("select max(number) as number,max(code) as code,max(name) as name,max(alias) as alias,max(date) as date,max(currency) as currency,
                            max(Rate) as rate,sum(quantity) as quantity,sum(subTotalVat) as subTotalVat, company from(SELECT  number,si.code,contacts.name,contacts.alias,
                            date(si.trans_date) as date,
                            app_currency.name as currency, app_currencyfx.buy_value as rate,
                            round(sum(sid.quantity),4) as quantity,
                            round(sum(sid.quantity * sid.unit_price * vatco.coef),4) as subTotalVat,
                            (
                            case when (si.id_contact=522 || si.id_contact=239 || si.id_contact=524 || si.id_contact = 523) then 'global' 
                            when (si.id_contact=240 || si.id_contact=527 || si.id_contact=526 || si.id_contact = 525) then 'Bivik' 
                            when (si.id_contact=241 || si.id_contact=538 || si.id_contact=536 || si.id_contact = 537) then 'Equus' 
                            when (si.id_contact=398 || si.id_contact=529 || si.id_contact=528 || si.id_contact = 530) then 'Desvio' 
                            else '' end )
                            as company
                            FROM sales_invoice si
                            inner join sales_invoice_detail sid on si.id_sales_invoice = sid.id_sales_invoice
                            LEFT OUTER JOIN
                            (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                            FROM  app_vat_group
                            LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                            LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                            GROUP BY app_vat_group.id_vat_group)
                            vatco ON vatco.id_vat_group = sid.id_vat_group
                            inner join contacts on contacts.id_contact = si.id_contact
                            inner join app_currencyfx on app_currencyfx.id_currencyfx = si.id_currencyfx
                            inner join app_currency on app_currency.id_currency = app_currencyfx.id_currency
                            where status=2 
                            and si.trans_date >= '" . $startDate . "' and si.trans_date <= '" . $endDate . "' 
                            and si.id_contact in (522,239,524,523,240,527,526,525,241,538,536,537,398,529,528,530)
                            group by si.number) as i group by company,alias ");

                         return   $salesData = collect($salesData);
           }

        public function SalesByClient(Request $request)
        {  
            $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }
           $salesData=$this->SalesByClientQuery($startDate,$endDate);
            
                              
                            return view('Dashboard.SalesByClientReport')
                            ->with('SalesByClient',$salesData);

        }
          public function ExportSalesClient(Request $request)
         {
            $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }
            $salesData = DB::select("select company as Empresa,max(date) as Fecha,max(alias) as Cliente,
                            max(number) as 'Nro de Factura',sum(quantity) as 'Cantidad Total',sum(subTotalVat) as 'Valor Total',
                            max(currency) as currency
                            from(SELECT  number,si.code,contacts.name,contacts.alias,
                            date(si.trans_date) as date,
                            app_currency.name as currency, app_currencyfx.buy_value as rate,
                            round(sum(sid.quantity),4) as quantity,
                            round(sum(sid.quantity * sid.unit_price * vatco.coef),4) as subTotalVat,
                            (
                            case when (si.id_contact=522 || si.id_contact=239 || si.id_contact=524 || si.id_contact = 523) then 'global' 
                            when (si.id_contact=240 || si.id_contact=527 || si.id_contact=526 || si.id_contact = 525) then 'Bivik' 
                            when (si.id_contact=241 || si.id_contact=538 || si.id_contact=536 || si.id_contact = 537) then 'Equus' 
                            when (si.id_contact=398 || si.id_contact=529 || si.id_contact=528 || si.id_contact = 530) then 'Desvio' 
                            else '' end )
                            as company
                            FROM sales_invoice si
                            inner join sales_invoice_detail sid on si.id_sales_invoice = sid.id_sales_invoice
                            LEFT OUTER JOIN
                            (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                            FROM  app_vat_group
                            LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                            LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                            GROUP BY app_vat_group.id_vat_group)
                            vatco ON vatco.id_vat_group = sid.id_vat_group
                            inner join contacts on contacts.id_contact = si.id_contact
                            inner join app_currencyfx on app_currencyfx.id_currencyfx = si.id_currencyfx
                            inner join app_currency on app_currency.id_currency = app_currencyfx.id_currency
                            where status=2 
                            and si.trans_date >= '" . $startDate . "' and si.trans_date <= '" . $endDate . "' 
                            and si.id_contact in (522,239,524,523,240,527,526,525,241,538,536,537,398,529,528,530)
                            group by si.number) as i group by company,alias ");

                         $salesData = collect($salesData);
           
                     
                  $data = json_decode( json_encode($salesData), true);
                
                  return   $this->ExportExcel($data , "Sales By Client" . '|' . $startDate . '-' . $endDate);
                              
         }
        
        public function SalesByMonth(Request $request)
        {
             $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }
            $query="SELECT  DATE_FORMAT(si.trans_date, '%M-%Y') as date,
            round(sum(sid.quantity),4) as Quantity,
            month(si.trans_date) as month,DATE_FORMAT(si.trans_date,'%Y') as year,
            round(sum(sid.quantity * sid.unit_price * vatco.coef),4) as SubTotalVat,
            app_currency.name as Currency,app_currencyfx.buy_value as Rate,
            contacts.name as customer,
            company.alias as company
            FROM sales_invoice si
            inner join app_company as company on si.id_company = company.id_company
            inner join sales_invoice_detail sid on si.id_sales_invoice = sid.id_sales_invoice
            LEFT OUTER JOIN
                (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                FROM  app_vat_group
                LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                GROUP BY app_vat_group.id_vat_group)
                vatco ON vatco.id_vat_group = sid.id_vat_group
            inner join contacts on contacts.id_contact = si.id_contact
            inner join app_currencyfx on app_currencyfx.id_currencyfx=si.id_currencyfx
            inner join app_currency on app_currency.id_currency=app_currencyfx.id_currency
            where  status = 2 and si.trans_date >= '" . $startDate . "' and si.trans_date <= '" . $endDate . "' 
            group by contacts.name, DATE_FORMAT(si.trans_date, '%M-%Y')
            order by si.id_company";

            $salesByMonth = DB::select($query);

            $salesByMonth = collect($salesByMonth);
            
            $Month = DB::select("select date from (" . $query .
             ") as a group by date order by year,month");

            $Month = collect($Month);

            return view('Dashboard.SalesByMonthReport')
            ->with('salesByMonth',$salesByMonth)
            ->with('Month',$Month);
        }

         public function ExportSalesByMonth(Request $request)
        {
             $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }
            $query="SELECT  DATE_FORMAT(si.trans_date, '%M-%Y') as date,
            round(sum(sid.quantity),4) as Quantity,
            month(si.trans_date) as month,DATE_FORMAT(si.trans_date,'%Y') as year,
            round(sum(sid.quantity * sid.unit_price * vatco.coef),4) as SubTotalVat,
            app_currency.name as Currency,app_currencyfx.buy_value as Rate,
            contacts.name as customer,
            company.alias as company
            FROM sales_invoice si
            inner join app_company as company on si.id_company = company.id_company
            inner join sales_invoice_detail sid on si.id_sales_invoice = sid.id_sales_invoice
            LEFT OUTER JOIN
                (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                FROM  app_vat_group
                LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                GROUP BY app_vat_group.id_vat_group)
                vatco ON vatco.id_vat_group = sid.id_vat_group
            inner join contacts on contacts.id_contact = si.id_contact
            inner join app_currencyfx on app_currencyfx.id_currencyfx=si.id_currencyfx
            inner join app_currency on app_currency.id_currency=app_currencyfx.id_currency
            where  status = 2 and si.trans_date >= '" . $startDate . "' and si.trans_date <= '" . $endDate . "' 
            group by contacts.name, DATE_FORMAT(si.trans_date, '%M-%Y')
            order by si.id_company";

            $salesByMonth = DB::select($query);

            $salesByMonth = collect($salesByMonth);
            
          
            
            $Month = DB::select("select date from (" . $query .
             ") as a group by date order by year,month");

              $Month = collect($Month);
             $collection = collect();
             foreach ($salesByMonth->groupBy('company') as $groupedByCompany)
               {
                foreach ($groupedByCompany->groupBy('customer') as $groupedByCustomer)
                {
                    $data=null;
                    $data['Cliente'] =  $groupedByCustomer->first()->customer ;
                    foreach($Month as $month)
                    {
                        $data[$month->date] = $salesByMonth->where('company',$groupedByCompany->first()->company)
											->where('customer',$groupedByCustomer->first()->customer)
											->where('date',$month->date )
											->first()!=null? number_format($salesByMonth->where('company',$groupedByCompany->first()->company)
											->where('customer',$groupedByCustomer->first()->customer)
											->where('date',$month->date)->first()->SubTotalVat,0) : 0;

                    }
                    $collection->push($data);
                }
            }
                $collection = json_decode( json_encode($collection), true);
                //dd($collection);
               return Excel::create("Sales By Month" . '|' . $startDate . '-' . $endDate, function($excel) use($salesByMonth,$collection) {
                        foreach ($salesByMonth->groupBy('company') as $groupedByCompany)
                        {
                             $excel->sheet($groupedByCompany->first()->company, function($sheet) use ($collection)
                                    {
                                        $sheet->fromArray($collection);
                            });
                        }
                  })->download('xls');  
                
               

           
        }
          public function SalesByMonthQuantity(Request $request)
        {
             $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }
            $query="SELECT  DATE_FORMAT(si.trans_date, '%M-%Y') as date,
            round(sum(sid.quantity),4) as Quantity,
            month(si.trans_date) as month,DATE_FORMAT(si.trans_date,'%Y') as year,
            round(sum(sid.quantity * sid.unit_price * vatco.coef),4) as SubTotalVat,
            app_currency.name as Currency,app_currencyfx.buy_value as Rate,
            contacts.name as customer,
            company.alias as company
            FROM sales_invoice si
            inner join app_company as company on si.id_company = company.id_company
            inner join sales_invoice_detail sid on si.id_sales_invoice = sid.id_sales_invoice
            LEFT OUTER JOIN
                (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                FROM  app_vat_group
                LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                GROUP BY app_vat_group.id_vat_group)
                vatco ON vatco.id_vat_group = sid.id_vat_group
            inner join contacts on contacts.id_contact = si.id_contact
            inner join app_currencyfx on app_currencyfx.id_currencyfx=si.id_currencyfx
            inner join app_currency on app_currency.id_currency=app_currencyfx.id_currency
            where  status = 2 and si.trans_date >= '" . $startDate . "' and si.trans_date <= '" . $endDate . "' 
            group by contacts.name, DATE_FORMAT(si.trans_date, '%M-%Y')
            order by si.id_company";

            $salesByMonth = DB::select($query);

            $salesByMonth = collect($salesByMonth);
            
            $Month = DB::select("select date from (" . $query .
             ") as a group by date order by year,month");

            $Month = collect($Month);

            return view('Dashboard.SalesByMonthQuantityReport')
            ->with('salesByMonth',$salesByMonth)
            ->with('Month',$Month);
        }

         public function ExportSalesByMonthQuantity(Request $request)
        {
             $startDate='2017-1-1';
              $endDate='2018-12-1';
            if ($request->startDate!=null)
            {
            $startDate=$request->startDate;
           
            }
              if ($request->endDate!=null)
            {
            $endDate=$request->endDate;
           
            }
            $query="SELECT  DATE_FORMAT(si.trans_date, '%M-%Y') as date,
            round(sum(sid.quantity),4) as Quantity,
            month(si.trans_date) as month,DATE_FORMAT(si.trans_date,'%Y') as year,
            round(sum(sid.quantity * sid.unit_price * vatco.coef),4) as SubTotalVat,
            app_currency.name as Currency,app_currencyfx.buy_value as Rate,
            contacts.name as customer,
            company.alias as company
            FROM sales_invoice si
            inner join app_company as company on si.id_company = company.id_company
            inner join sales_invoice_detail sid on si.id_sales_invoice = sid.id_sales_invoice
            LEFT OUTER JOIN
                (SELECT app_vat_group.id_vat_group, SUM(app_vat.coefficient * app_vat_group_details.percentage) + 1 AS coef, app_vat_group.name as VAT
                FROM  app_vat_group
                LEFT OUTER JOIN app_vat_group_details ON app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
                LEFT OUTER JOIN app_vat ON app_vat_group_details.id_vat = app_vat.id_vat
                GROUP BY app_vat_group.id_vat_group)
                vatco ON vatco.id_vat_group = sid.id_vat_group
            inner join contacts on contacts.id_contact = si.id_contact
            inner join app_currencyfx on app_currencyfx.id_currencyfx=si.id_currencyfx
            inner join app_currency on app_currency.id_currency=app_currencyfx.id_currency
            where  status = 2 and si.trans_date >= '" . $startDate . "' and si.trans_date <= '" . $endDate . "' 
            group by contacts.name, DATE_FORMAT(si.trans_date, '%M-%Y')
            order by si.id_company";

            $salesByMonth = DB::select($query);

            $salesByMonth = collect($salesByMonth);
            
          
            
            $Month = DB::select("select date from (" . $query .
             ") as a group by date order by year,month");

              $Month = collect($Month);
             $collection = collect();
             foreach ($salesByMonth->groupBy('company') as $groupedByCompany)
               {
                foreach ($groupedByCompany->groupBy('customer') as $groupedByCustomer)
                {
                    $data=null;
                    $data['Cliente'] =  $groupedByCustomer->first()->customer ;
                    foreach($Month as $month)
                    {
                        $data[$month->date] = $salesByMonth->where('company',$groupedByCompany->first()->company)
											->where('customer',$groupedByCustomer->first()->customer)
											->where('date',$month->date )
											->first()!=null? number_format($salesByMonth->where('company',$groupedByCompany->first()->company)
											->where('customer',$groupedByCustomer->first()->customer)
											->where('date',$month->date)->first()->Quantity,0) : 0;

                    }
                    $collection->push($data);
                }
            }
                $collection = json_decode( json_encode($collection), true);
                //dd($collection);
               return Excel::create("Sales By Month" . '|' . $startDate . '-' . $endDate, function($excel) use($salesByMonth,$collection) {
                        foreach ($salesByMonth->groupBy('company') as $groupedByCompany)
                        {
                             $excel->sheet($groupedByCompany->first()->company, function($sheet) use ($collection)
                                    {
                                        $sheet->fromArray($collection);
                            });
                        }
                  })->download('xls');  
                
               

           
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

        public function ExportExcel($data,$name)
        {
             return Excel::create($name, function($excel) use ($data) {
                                    $excel->sheet('Sheet1', function($sheet) use ($data)
                                    {
                                        $sheet->fromArray($data);
                                    });
                            })->download('xls');
        }

       

      

        

        public function ManageDashboard(){
            $Components = (new ComponentController)->ManageComponents();
            return view('Dashboard.ConfigComponents')->with('Components',$Components);
        }
    }

    
