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
  public function porcentajeprodvendidopordia(){
    $date6monago = date("Y-m-d", strtotime("-6 months"));
    $query = "select
              	i.name,
              	date(si.trans_date) as fecha,
                round((sum(quantity)/cantpordia.cantidadpordia)*100,2) as porcentaje
              from sales_invoice as si
              left join sales_invoice_detail as sid
              on sid.id_sales_invoice = si.id_sales_invoice
              left join (select sum(quantity) as cantidadpordia,date(si1.trans_date) as fecha
              			from sales_invoice as si1
                          left join sales_invoice_detail as sid1
                          on si1.id_sales_invoice= sid1.id_sales_invoice
                          group by date(trans_date)) as cantpordia
              on date(si.trans_date) = cantpordia.fecha
              left join items as i
              on i.id_item = sid.id_item
              left join item_tag_detail as itd
              on itd.id_item = i.id_item
              left join item_tag as it
              on it.id_tag = itd.id_tag
              where si.trans_date between '" . $date6monago . "' and now()
              and si.id_company = 1
              and id_branch = 1
              group by sid.id_item, date(si.trans_date)
              order by sid.id_item,date(si.trans_date);";
    $data = DB::select(DB::raw($query));
    return Response::json($data);
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
}
