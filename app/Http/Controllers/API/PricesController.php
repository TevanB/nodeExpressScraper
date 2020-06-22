<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricesController extends Controller
{
  public function getPrice(Request $input)
  {
    $prices = DB::table('prices')->get();
    $result = 0;
    $orderType = $input->order_type;
    //return $input->divisions;
    //return $input;

    if($orderType=='solodiv' || $orderType == 'duodiv'){
      foreach($input->divisions as $item){
        $temp = DB::table('prices')->where('type', $input->order_type)->where('divisions', $item)->value('price');
        $result = $result + $temp;
      }
    }
    elseif($orderType=='solonet' || $orderType == 'duonet'){
      $temp = DB::table('prices')->where('type', $input->order_type)->where('divisions', $input->netwin_rank)->value('price');
      $result = $temp * $input->quantity;

    }
    elseif($orderType=='soloplace' || $orderType == 'duoplace'){
      $temp = DB::table('prices')->where('type', $input->order_type)->where('divisions', $input->placement_rank)->value('price');

      $result = $temp * $input->quantity;

    }
    
    return $result;

  }
  public function verifyDiscount(Request $request, $id)
  {
    $temp = DB::table('dicounts')->where('code', $id);
    $return =  $temp->value('type') . " " . $temp->value('amount');
    return $return;

  }
}
