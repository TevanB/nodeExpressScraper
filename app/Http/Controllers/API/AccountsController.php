<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
  public function checkAcc(Request $request)
  {
    $user = DB::table('users')->where('email', $request->emailAddress)->value('id');
    //echo json_encode($user);
    if($user){
      return $user;
    }

    if(!$user)
    return "false";


  }
}
