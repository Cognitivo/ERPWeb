<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Response;
use View;

class dashboardController extends Controller
{
  public function index(Request $request){
      $username = $request->session()->get('username');
      return view('ERPWeb',compact('username'));
  }
}
