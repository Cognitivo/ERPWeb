<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Response;
use View;

class dashboardcontroller extends Controller
{
  public function index(){
      return view('ERPWeb',compact('json_file'));
  }
  public function login(){
    return view('login');
  }
  public function authenticate(Request $request){
    $username = trim($request["username"]);
    $password = trim($request["password"]);
    if($username != "" and $password != ""){
      $query = "select id_user from security_user where email_username = '" + $username +"' and email_password='"
                + $password + "'";
    }
  }
}
