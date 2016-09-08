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
      return view('Dashboard.launch');
  }
  public function SaveDashboard(Request $request){
    $Name = Auth::user()->name;
    if (!file_exists(Config::get("Paths.UserDashboard") . $Name . "/")) {
      File::makeDirectory(Config::get("Paths.UserDashboard") . $Name . "/");
    }
    dd($request->all());
    try{
      foreach (Input::get('components') as $Comp) {
        $DashboardComponents[] = $Comp;
      }
      dd($DashboardComponents);
      file_put_contents(Config::get("Paths.UserDashboard") . $Name . "/dashboard.json",json_encode($DashboardComponents));
    }
    catch(Exception $e){
      return $e->getMessage();
    }
    return true;
  }
  public function ManageDashboard(){
    $Components = (new ComponentController)->ManageComponents();
    return view('Dashboard.ConfigComponents')->with('Components',$Components);
  }
}
