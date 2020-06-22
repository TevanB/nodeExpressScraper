<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Order extends Model
{
    //use Uuids;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';

    //assuming below gets uuid
    public $uuid = 'project_uuid';


    protected $fillable = [
        'order_id', 'order_type', 'order_price', 'order_message', 'order_status', 'payout_status', 'booster_id', 'client_id', 'created_at',
    ];

    //default values
    /*protected $attributes = [
      'order_id' = $uuid,
    ];*/

}
