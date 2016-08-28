<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Orderincominginvoice extends Model
{
    //use LogsActivity;

    protected $table   ='order_incoming_invoices';
    protected $guarded =['id'];
    public $timestamps = false;

    protected static $logAttributes = ['order_id', 'total', 'payed_at'];
}
