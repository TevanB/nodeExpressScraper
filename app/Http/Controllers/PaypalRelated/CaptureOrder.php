<?php

namespace App\Http\Controllers\PaypalRelated;

//require __DIR__ . '/vendor/autoload.php';
//1. Import the PayPal SDK client that was created in `Set up Server-Side SDK`.
use App\Http\Controllers\PaypalRelated\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Illuminate\Http\Request;
use App\User;
use App\Mail\ClientNewOrderMail;
use App\Mail\AdminNewOrderMail;
use App\Events\NewPurchase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CaptureOrder
{

  // 2. Set up your server to receive a call from the client
  /**
   *This function can be used to capture an order payment by passing the approved
   *order ID as argument.
   *
   *@param debug
   *@returns
   */
  public static function captureOrder($debug=false)
  {

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    $orderId = $data->orderID;
    $invoiceID = $data->id_invoice;
    $orderObj = $data->orderObj;
    $orderMessage = $data->message;
    $orderPrice = $data->price;
    $existStatus = $data->accountExists;
    $orderType = $data->orderType;
    $o1=$data->orderOne;
    $o2=$data->orderTwo;
    $o3=$data->orderThree;
    $clientEmail = $data->client_email;
    //$clientID = $data->clienter_id;
    $request = new OrdersCaptureRequest($orderId);

    // 3. Call PayPal to capture an authorization
    $client = PayPalClient::client();
    if($request){
      $response = $client->execute($request);
    }
    // 4. Save the capture ID to your database. Implement logic to save capture to your database for future reference.
    if ($debug)
    {
      print "Status Code: {$response->statusCode}\n";
      print "Status: {$response->result->status}\n";
      print "Order ID: {$response->result->id}\n";
      print "Client ID: {$clientID}\n";
      print "Links:\n";
      foreach($response->result->links as $link)
      {
        print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
      }
      print "Capture Ids:\n";
      foreach($response->result->purchase_units as $purchase_unit)
      {
        foreach($purchase_unit->payments->captures as $capture)
        {
          print "\t{$capture->id}";
        }
      }
      // To print the whole response body, uncomment the following line
       echo json_encode($response->result, JSON_PRETTY_PRINT);
    }
    //SAVE ORDER TO DATABASE Below



    DB::table('orders')->insert([
      'order_id' => $invoiceID,
      'client_id' => json_decode($orderObj)->client_id,
      'order_type' => $orderType,
      'order_price' => $response->result->purchase_units[0]->payments->captures[0]->amount->value,
      'order_status' => 'unclaimed',
      'order_message' => $orderMessage,
      'payout_status' => 'in-progress',
      'created_at' => date('Y-m-d H:i:s')

    ]);


    Mail::to($clientEmail)->send(new ClientNewOrderMail(json_decode($orderObj), $orderPrice, $o1, $o2, $o3));
    Mail::to("admin@bmsboosting.com")->send(new AdminNewOrderMail(json_decode($orderObj), $orderPrice, $o1, $o2, $o3, json_decode($orderMessage)));

    broadcast(new NewPurchase())->toOthers();

    if($existStatus){
      $user = User::findOrFail(json_decode($orderObj)->client_id);

      echo $user;
      if($user){
        $prevArr = $user->ongoing_orders_arr;
        $orderNum = $user->ongoing_orders;
        $orderNum = $orderNum + 1;
        array_push($prevArr, json_decode($orderObj));
        $user->update([
          'ongoing_orders_arr' => $prevArr,
          'ongoing_orders' => $orderNum,
        ]);
      }
    }
    //add order message above
    //return json_encode($response);
  }
}

/**
 *This driver function invokes the captureOrder function with
 *approved order ID to capture the order payment.
 */
if (!count(debug_backtrace()))
{
  CaptureOrder::captureOrder('REPLACE-WITH-APPORVED-ORDER-ID', true);
}
?>
