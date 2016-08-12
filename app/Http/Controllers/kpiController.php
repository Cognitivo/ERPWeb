<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Response;
use View;
use Config;

class kpiController extends Controller
{
    public function Execute_KPI($Key, $StartDate, $EndDate){

        //search for JsonKey
        $ComponentConfigJson = file_get_contents(Config::get("Paths.Components") . $Key . ".json");
        $ComponentConfig = json_decode($ComponentConfigJson,true);

       
        switch($ComponentConfig["Type"]){
          case "Kpi":
            self::ExecuteKpi($Key,$StartDate,$EndDate);

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
    $Data = DB::select(DB::raw($Query));
    $Response[$ComponentConfig["Value"]] = $Data[0]->{$ComponentConfig["Value"]};
    $Response["Type"] = $ComponentConfig["Type"];
    $Response["Dimensions"] = $ComponentConfig["Dimensions"];
    $Response["Caption"] = $ComponentConfig["Caption"];
    $Response["Value"] = $ComponentConfig["Value"];


    return json_encode($Response);

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
}
