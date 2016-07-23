<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Response;
use View;

class kpicontroller extends Controller
{
  public function facturaspordia(){
      $cantidadfactura = array();
      $fecha = array();
      $date6monago = date("Y-m-d", strtotime("-6 months"));
      $query = "select
	               count(id_sales_invoice) as cantidad,
                 date(trans_date) as fecha,
                b.name as sucursal
                from sales_invoice as si
                left join app_branch as b
                on si.id_branch = b.id_branch
                where si.id_company = 1
                and si.trans_date between '" . $date6monago . "' and now()
                and si.id_branch = 1
              group by date(trans_date)
              order by date(trans_date)";
      $data =   DB::select(DB::raw($query));
      foreach($data as $entry){
        $cantidadfactura[] = $entry->cantidad;
        $fecha[] = $entry->fecha;
        $sucursal[] = $entry->sucursal;
      }
      $response = array("cantidadfactura"=>$cantidadfactura,"fecha"=>$fecha);
      return Response::json($response);
  }
  public function top10products(){
    $cantidad = array();
    $producto = array();
    $date6monago = date("Y-m-d", strtotime("-6 months"));
    $query = "select i.name,sum(quantity) as cantidad
              from sales_invoice as si
              left join sales_invoice_detail as sid
              on si.id_sales_invoice = sid.id_sales_invoice
              left join items as i
              on i.id_item = sid.id_item
              where si.trans_date between '" . $date6monago . "' and now()
              and si.id_company = 1
              group by sid.id_item
              order by sum(quantity) desc limit 10";
    $data = DB::select(DB::raw($query));
    foreach($data as $entry){
      $cantidad[] = $entry->cantidad;
      $producto[] = $entry->name;
    }
    $response = array("cantidad"=>$cantidad,"producto"=>$producto);
    return Response::json($response);
  }
  public function porcentajetag(){
    $date6monago = date("Y-m-d", strtotime("-6 months"));
    $tags = array();
    $percentages = array();
    $query = "select
	             it.name,
              round((sum(quantity)/(select
          							sum(quantity)
                                      from sales_invoice as si1
                                      left join sales_invoice_detail as sid1
                                      on si1.id_sales_invoice = sid1.id_sales_invoice
                                      where si1.trans_date
                                      between '2016-05-01' and now())*100),2) as porcentaje
              from sales_invoice as si
              left join sales_invoice_detail as sid
              on sid.id_sales_invoice = si.id_sales_invoice
              left join items as i
              on i.id_item = sid.id_item
              left join item_tag_detail as itd
              on itd.id_item = i.id_item
              left join item_tag as it
              on it.id_tag = itd.id_tag
              where si.trans_date between '".$date6monago."' and now()
              and si.id_company = 1
              group by it.id_tag
              order by it.id_tag";
    $data = DB::select(DB::raw($query));
    foreach($data as $entry){
      $tags[] = $entry->name;
      $percentages[] = $entry->porcentaje;
    }
    return Response::json(array("tags"=>$tags,"percentage"=>$percentages));
  }
  public function totalsales(){
    $startdate = date("Y") . "-01-01";
    $query = "select sum(quantity*unit_price*vatco.coef) as totalsales
              from sales_invoice as si
              left join sales_invoice_detail as sd
              on si.id_sales_invoice = sd.id_sales_invoice
              left join
              	(select app_vat_group.id_vat_group,sum(app_vat.coefficient) + 1 as coef
                  from app_vat_group
              	left join app_vat_group_details
                  on app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
              	left join app_vat
                  on app_vat_group_details.id_vat = app_vat.id_vat
                  group by app_vat_group.id_vat_group) as vatco
              on sd.id_vat_group = vatco.id_vat_group
              where si.trans_date > '" . $startdate . "'";
    $data = DB::select(DB::raw($query));
    return Response::json($data);
  }
  public function getconfig(){
    $json_file = file_get_contents(storage_path() . "/app/config/components.json");
    return $json_file;
  }
  public function averagesalesperinv(){
    $date1monago = date("Y-m-d", strtotime("-1 months"));
    $query = "select ifnull(avg(salesperinvoice),0) as averagesalesperinv
              from (select sum(sid.quantity*sid.unit_price)as salesperinvoice , si.id_sales_invoice
              from sales_invoice as si
              left join sales_invoice_detail as sid
              on si.id_sales_invoice = sid.id_sales_invoice
              where si.trans_date between '" . $date1monago . "' and now()
              group by si.id_sales_invoice) as QuantityPerInvoice";
    $data = DB::select(DB::raw($query));
    return Response::json($data);
  }
  public function averagequantityperinv(){
    $date1monago = date("Y-m-d", strtotime("-1 months"));
    $query = "select ifnull(avg(qtyperinvoice),0) as averagequantityperinv
              from (select sum(sid.quantity)as qtyperinvoice , si.id_sales_invoice
              from sales_invoice as si
              left join sales_invoice_detail as sid
              on si.id_sales_invoice = sid.id_sales_invoice
              where si.trans_date between '" . $date1monago . "' and now()
              group by si.id_sales_invoice) as QuantityPerInvoice";
    $data = DB::select(DB::raw($query));
    return Response::json($data);
  }
  public function salesperfootfall(){
    $date1monago = date("Y-m-d", strtotime("-1 months"));
    $sales = 0;
    $footfall = 0;
    $queryfootfall = "select ifnull(sum(quantity),0) as footfall
                      from app_branch_walkins
                      where timestamp between '" . $date1monago . "' and now()";
    $querytotalsales = "select sum(sid.quantity * sid.unit_price) as sales
                        from sales_invoice as si
                        left join sales_invoice_detail as sid
                        on si.id_sales_invoice = sid.id_sales_invoice
                        where si.trans_date between '" . $date1monago . "' and now()";
    $footfalldata = DB::select(DB::raw($queryfootfall));
    $salesdata = DB::select(DB::raw($querytotalsales));
    foreach ($footfalldata as $ff) {
      $footfall = $ff->footfall;
    }
    foreach ($salesdata as $s) {
      $sales = $s->sales;
    }
    if($footfall == 0)
      $response = 0;
    else {
      $response = $sales/$footfall;
    }

    return $response;
  }
}
