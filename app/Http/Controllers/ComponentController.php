<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Response;
use View;
use Config;
use Auth;
use File;
use Redirect;
class ComponentController extends Controller
{
    public function Execute_KPI($Key, $StartDate, $EndDate){

        //search for JsonKey
        $ComponentConfigJson = file_get_contents(Config::get("Paths.Components") . $Key . ".json");
        $ComponentConfig = json_decode($ComponentConfigJson,true);

        switch(strtolower($ComponentConfig["Type"])){
          case "kpi":
            return $this->ExecuteKpi($Key,$StartDate,$EndDate);

            break;
          case "piechart":
            return $this->ExecutePie($Key,$StartDate,$EndDate);
            break;
          case "barchart":
            return $this->ExecuteBar($Key,$StartDate,$EndDate);
            break;
          default:
            return "no match";
        }
        // $Key = __NAMESPACE__. '\kpicontroller::' . $Key;
        // return call_user_func_array($Key, array($StartDate , $EndDate));
    }
  public function ExecuteKpi($Key,$StartDate,$EndDate){

    $ComponentConfigJson = file_get_contents(Config::get("Paths.Components") . $Key . ".json");
    $Response = array();
    $ComponentConfig = json_decode($ComponentConfigJson,true);

    $Query = file_get_contents(Config::get("Paths.SQLs") . $ComponentConfig["SqlFile"]);
    $Parameters = explode(",",$ComponentConfig["Parameters"]);
    foreach ($Parameters as $Parameter) {
      $Query = str_replace("@" . $Parameter,"'" . ${$Parameter} . "'", $Query);
    }
      $Query = str_replace("@db",DB::getDatabaseName(),$Query);
    
    $Data = DB::select($Query);



    $Response[$ComponentConfig["Value"]] = $Data[0]->{$ComponentConfig["Value"]};
    $Response["Type"] = $ComponentConfig["Type"];
    $Response["Dimensions"] = $ComponentConfig["Dimensions"];
    $Response["Caption"] = $ComponentConfig["Caption"];
    $Response["Value"] = $ComponentConfig["Value"];
    $Response["Unit"] = $ComponentConfig["Unit"];
    $Response["Key"] = $Key;
    return Response::json($Response);

  }
  public function ExecutePie($Key,$StartDate,$EndDate){
    $ComponentConfigJson = file_get_contents(Config::get("Paths.Components") . $Key . ".json");
    $Response = array();
    $ComponentConfig = json_decode($ComponentConfigJson,true);
    $Query = file_get_contents(Config::get("Paths.SQLs") . $ComponentConfig["SqlFile"]);
    $Parameters = explode(",",$ComponentConfig["Parameters"]);
    foreach ($Parameters as $Parameter) {
      $Query = str_replace("@" . $Parameter,"'" . ${$Parameter} . "'", $Query);
    }
    $Data = DB::select(DB::raw($Query));
    foreach ($Data as $Row) {
      $Response[$ComponentConfig["Label"]][] = $Row->{$ComponentConfig["Label"]};
      $Response[$ComponentConfig["PieValues"]][] = $Row->{$ComponentConfig["PieValues"]};
    }
    $Response["Type"] = $ComponentConfig["Type"];
    $Response["Dimensions"] = $ComponentConfig["Dimensions"];
    $Response["Caption"] = $ComponentConfig["Caption"];
    $Response["Label"] = $ComponentConfig["Label"];
    $Response["PieValues"] = $ComponentConfig["PieValues"];
    $Response["Key"] = $Key;
    return Response::json($Response);

  }
  public function ExecuteBar($Key,$StartDate,$EndDate){
    $ComponentConfigJson = file_get_contents(Config::get("Paths.Components") . $Key . ".json");
    $Response = array();
    $ComponentConfig = json_decode($ComponentConfigJson,true);
    $Response[$ComponentConfig["Label"]] = array();
    $Query = file_get_contents(Config::get("Paths.SQLs") . $ComponentConfig["SqlFile"]);
    $Parameters = explode(",",$ComponentConfig["Parameters"]);
    foreach ($Parameters as $Parameter) {
      $Query = str_replace("@" . $Parameter,"'" . ${$Parameter} . "'", $Query);
    }
    $Data = DB::select(DB::raw($Query));
    foreach ($Data as $Row) {
      $Response[$ComponentConfig["Label"]][] = $Row->{$ComponentConfig["Label"]};
      foreach($ComponentConfig["Series"] as $Series){
        $Response[$Series["Column"]][] = $Row->{$Series["Column"]};
      }
    }
    $Response["Data"] = $Data;
    $Response["Type"] = $ComponentConfig["Type"];
    $Response["Dimensions"] = $ComponentConfig["Dimensions"];
    $Response["Caption"] = $ComponentConfig["Caption"];
    $Response["Label"] = $ComponentConfig["Label"];
    $Response["Series"] = $ComponentConfig["Series"];
    $Response["Key"] = $Key;
    return Response::json($Response);
  }
  public function GetUserComponents(){
    $Name = Auth::user()->name;
    $UserComponents = array();
    $Components = array();
    if(File::exists(Config::get("Paths.UserDashboard") . $Name . "/dashboard.json")){
      $Components = json_decode(file_get_contents(Config::get("Paths.UserDashboard") . $Name . "/dashboard.json",true),true);
      if(is_array($Components)){
        foreach ($Components as $Key => $ComponentKey) {
          if(File::exists(Config::get("Paths.Components") . $ComponentKey . ".json")){
            $ComponentName = json_decode(file_get_contents(Config::get("Paths.Components") . $ComponentKey . ".json"),true)["Caption"];
            $UserComponents[$ComponentKey] = $ComponentName;
          }
        }
      }

    }
    asort($UserComponents);
    return json_encode($UserComponents);
  }
  public function ManageComponents(){
    $Directory = new \RecursiveDirectoryIterator(storage_path() . "/app/config/Components",
                                                    \RecursiveDirectoryIterator::KEY_AS_FILENAME |
                                                    \RecursiveDirectoryIterator::CURRENT_AS_FILEINFO);
    $Iterator = new \RecursiveIteratorIterator($Directory);
    $ComponentJsonFiles = new \RegexIterator($Iterator, "/.*\.json$/i", \RegexIterator::MATCH,
                                                                    \RegexIterator::USE_KEY);
    $Components = array();
    $Components["User"] = json_decode($this->GetUserComponents(),true);
    foreach($ComponentJsonFiles as $File){
      $Json = json_decode(file_get_contents($File),true);
      $FileInfo = pathinfo($File);
      $Components["All"][$FileInfo["filename"]] = $Json["Caption"];
    }
    asort($Components["All"]);
    return $Components;
  }
  public function ListComponents(){
    $Directory = new \RecursiveDirectoryIterator(storage_path() . "/app/config/Components",
                                                    \RecursiveDirectoryIterator::KEY_AS_FILENAME |
                                                    \RecursiveDirectoryIterator::CURRENT_AS_FILEINFO);
    $Iterator = new \RecursiveIteratorIterator($Directory);
    $ComponentJsonFiles = new \RegexIterator($Iterator, "/.*\.json$/i", \RegexIterator::MATCH,
                                                                    \RegexIterator::USE_KEY);
    $Components = array();
    $Ctr = 0;
    foreach($ComponentJsonFiles as $File){
      $Components[] = json_decode(file_get_contents($File),true);
      $FileInfo = pathinfo($File);
      $Components[$Ctr]["Key"] = $FileInfo["filename"];
      $Ctr++;
    }
    return View::make('components.list.components',compact('Components'));
  }
  public function ShowCreate(){
    return View::make('components.forms.components');
  }
  public function ShowUpdate($Key = null){
    if($Key){
      if(File::exists(Config::get("Paths.Components") . $Key . ".json")){
        $ComponentInfo = json_decode(file_get_contents(Config::get("Paths.Components") . $Key . ".json"),true);
        $FileInfo = pathinfo(Config::get("Paths.Components") . $Key . ".json");
        $ComponentInfo["Key"] = $FileInfo["filename"];
        $ComponentInfo["Query"] = file_get_contents(Config::get("Paths.SQLs")."/".$Key.".sql");
        return View::make('components.forms.components')->with('ComponentInfo',$ComponentInfo);
      }
    }
  }
  public function CreateComponent(Request $request){
    $Component = array();
    $Value = "";
    $KeyElem = explode(" ", $request->input("name"));
    foreach ($KeyElem as $index => $value) {
      $KeyElem[$index] = substr($value,0,3);
    }
    $Key = implode("",$KeyElem);
    $Pattern = '/(?<!\w)@\w+/';
    preg_match_all($Pattern, $request->input("query"), $Matches);
    $Matches = array_unique($Matches[0]);
    foreach ($Matches as $key => $value) {
      $Matches[$key] = ltrim($value,"@");
    }
    $Parameters = implode(",",$Matches);
    $Result=preg_split('/as/',$request->input("query"));
    if(count($Result)>1){
      $Result_split=explode(' ',$Result[1]);
      $Value = trim($Result_split[1]);
    }

    $Component["Caption"] = $request->input("name");
    $Component["Type"] = $request->input("type");
    $Component["Unit"] = $request->input("unit");
    $Component["Module"] = $request->input("module");
    $Component["Description"] = $request->input("description");
    $Component["Parameters"] = $Parameters;
    $Component["Value"] = $Value;
    $Component["SqlFile"] = $Key . ".sql";
    switch(strtolower($request->input("type"))){
      case "kpi":
        $Component["Dimensions"] = "Small";
        break;
      case "barchart":
        $Component["Dimensions"] = "Medium";
        $Component["Label"] = $request->input("xaxis");
        $Component["Series"][0]["Id"] = $request->input("yaxis");
        $Component["Series"][0]["Name"] = $request->input("yaxiscaption");
        $Component["Series"][0]["Column"] = $request->input("yaxiscolumn");
        $Component["Series"][0]["Color"] = $request->input("yaxiscolor");
        break;
      case "piechart":
        $Component["Dimensions"] = "Medium";
        $Component["Label"] = $request->input("label");
        $Component["PieValues"] = $request->input("pievalues");
        break;
    }
    file_put_contents(Config::get("Paths.SQLs")."/".$Key.".sql", $request->input("query"));
    file_put_contents(Config::get("Paths.Components") . "/" . $Key . ".json",json_encode($Component));
    return redirect('componentslist');
  }
  public function UpdateComponent(Request $request){
    $Key = $request->input("key");

    $Pattern = '/(?<!\w)@\w+/';
    preg_match_all($Pattern, $request->input("query"), $Matches);
    $Matches = array_unique($Matches[0]);
    foreach ($Matches as $key => $value) {
      $Matches[$key] = ltrim($value,"@");
    }
    $Parameters = implode(",",$Matches);
    $Parameters = implode(",",$Matches);
    $Component["Caption"] = $request->input("name");
    $Component["Type"] = $request->input("type");
    $Component["Unit"] = $request->input("unit");
    $Component["Module"] = $request->input("module");
    $Component["Description"] = $request->input("description");
    $Component["Parameters"] = $Parameters;
    $Component["SqlFile"] = $Key . ".sql";

    switch(strtolower($request->input("type"))){
      case "kpi":
        $Component["Dimension"] = "Small";
        break;
      case "barchart":
        $Component["Dimension"] = "Medium";
        $Component["Label"] = $request->input("xaxis");
        $Component["Series"][0]["Id"] = $request->input("yaxis");
        $Component["Series"][0]["Name"] = $request->input("yaxiscaption");
        $Component["Series"][0]["Column"] = $request->input("yaxiscolumn");
        $Component["Series"][0]["Color"] = $request->input("yaxiscolor");
        break;
      case "piechart":
        $Component["Dimension"] = "Medium";
        $Component["Label"] = $request->input("label");
        $Component["PieValues"] = $request->input("pievalues");
        break;
    }
    file_put_contents(Config::get("Paths.SQLs")."/".$Key.".sql", $request->input("query"));
    file_put_contents(Config::get("Paths.Components") . "/" . $Key . ".json",json_encode($Component));
    return redirect('componentslist');
  }
  public function GetTables($StartDate,$EndDate){
    $salespercustomer = DB::select("
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
    where si.trans_date between '". $StartDate ."' and '". $EndDate ."'
    group by  si.id_contact");

        $salespercustomer = collect($salespercustomer);

        $quantitypercustomer = DB::select("
        select contacts.name as contact,
        round(sum(quantity)) as quantity
        from sales_invoice as si
        left join sales_invoice_detail as sd
        on si.id_sales_invoice = sd.id_sales_invoice
        left join contacts
        on contacts.id_contact = si.id_contact
        where si.trans_date between '". $StartDate ."' and '". $EndDate ."'
        group by  contacts.id_contact");

        $quantitypercustomer = collect($quantitypercustomer);
        if($salespercustomer->count() > 0)
          $response['salespercustomer'] = $salespercustomer;
        else
          $response['salespercustomer'] = "No hay datos";
        if($quantitypercustomer->count() > 0)
          $response['quantitypercustomer'] = $quantitypercustomer;
        else
          $response['quantitypercustomer'] = "No hay datos";
        return Response::json($response);
  }
}
