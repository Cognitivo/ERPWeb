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
            ExecuteKpi($Key,$StartDate,$EndDate);
          case "Pie":
            ExecutePie($Key,$StartDate,$EndDate);
          case "Bar":
            ExecuteBar($Key,$StartDate,$EndDate);
        }
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
    $Response["Data"] = $Data;
    $Response["Type"] = $ComponentConfig["Type"];
    $Response["Dimensions"] = $ComponentConfig["Dimensions"];
    $Response["Caption"] = $ComponentConfig["Caption"];
    $Response["Value"] = $ComponentConfig["Value"];
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
    $Response["Data"] = $Data;
    $Response["Type"] = $ComponentConfig["Type"];
    $Response["Dimensions"] = $ComponentConfig["Dimensions"];
    $Response["Caption"] = $ComponentConfig["Caption"];
    $Response["Label"] = $ComponentConfig["Label"];
    $Response["PieValues"] = $ComponentConfig["PieValues"];
    return Response::json($Response);

  }
  public function ExecuteBar($Key,$StartDate,$EndDate){
    $ComponentConfigJson = file_get_contents(Config::get("Paths.Components") . $Key . ".json");
    $Response = array();
    $ComponentConfig = json_decode($ComponentConfigJson,true);
    $Query = file_get_contents(Config::get("Paths.SQLs") . $ComponentConfig["SqlFile"]);
    $Parameters = explode(",",$ComponentConfig["Parameters"]);
    foreach ($Parameters as $Parameter) {
      $Query = str_replace("@" . $Parameter,"'" . ${$Parameter} . "'", $Query);
    }
    $Data = DB::select(DB::raw($Query));
    $Response["Data"] = $Data;
    $Response["Type"] = $ComponentConfig["Type"];
    $Response["Dimensions"] = $ComponentConfig["Dimensions"];
    $Response["Caption"] = $ComponentConfig["Caption"];
    $Response["Label"] = $ComponentConfig["Label"];
    $Response["Series"] = $ComponentConfig["Series"];
    return Response::json($Response);
  }
}
