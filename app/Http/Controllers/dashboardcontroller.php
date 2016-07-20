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
}
