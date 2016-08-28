<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Booking extends Model
{
    //use LogsActivity;

    protected $table ='orders';
    protected $guarded =['id'];

    protected static $logAttributes = ['status', 'source', 'payed_at', 'cancelled_at', 'created_at', 'updated_at'];
}
