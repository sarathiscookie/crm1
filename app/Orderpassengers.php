<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Orderpassengers extends Model
{
    //use LogsActivity;

    protected $table ='order_passengers';
    protected $guarded =['id'];

    protected static $logAttributes = ['order_id', 'customer_id', 'invoice'];
}
