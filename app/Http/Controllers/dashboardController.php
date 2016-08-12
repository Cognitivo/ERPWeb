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

class dashboardController extends Controller
{
  public function index(Request $request){
      return view('master');
  }
  public function SaveDashboard(Request $request){
    $Name = Auth::user()->name;
    File::makeDirectory(Config::get("Paths.Components") . $Name . "/");
    File::put(Config::get("Paths.Components") . $Name . "/dashboard.json",json_encode(Input::get("components")));
  }
  public function ManageDashboard(){
    $Name = Auth::user()->name;
    if(File::exists(Config::get("Paths.Components") . $Name . "/dashboard.json")){
      $DashboardComponents = file_get_contents(Config::get("Paths.Components") . $Name . "/dashboard.json",true);
      return view('Dashboard.ConfigComponents',compact('DashboardComponents'));
    }
    else{
      $Errors = ["error"=>"NoComponents"];
      return view('Dashboard.ConfigComponents',compact('Errors'));
    }
  }
  public function ListComponents(){
    $Directory = new \RecursiveDirectoryIterator(storage_path() . "/app/config/Components",
                                                    \RecursiveDirectoryIterator::KEY_AS_FILENAME |
                                                    \RecursiveDirectoryIterator::CURRENT_AS_FILEINFO);
    $Iterator = new \RecursiveIteratorIterator($Directory);
    $ComponentJsonFiles = new \RegexIterator($Iterator, "/.*\.json$/i", \RegexIterator::MATCH,
                                                                    \RegexIterator::USE_KEY);
    $Components = array();
    foreach($ComponentJsonFiles as $File){
      $Json = json_decode(file_get_contents($File),true);
      $FileInfo = pathinfo($File);
      $Components[$Json["Caption"]] = $FileInfo["filename"];
    }
    return View::make('Dashboard.ListComponents')->with('Components',$Components);
  }
}
