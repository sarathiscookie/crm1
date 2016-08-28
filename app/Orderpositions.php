<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Orderpositions extends Model
{
    //use LogsActivity;

    protected $table ='order_positions';
    protected $guarded =['id'];

    protected static $logAttributes = ['quantity', 'title', 'price', 'cost', 'type'];
}
