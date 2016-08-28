<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Model
{
    //use LogsActivity;

    protected $table ='customers';
    protected $guarded =['id'];

    protected static $logAttributes = ['firstname', 'lastname', 'mail', 'postal', 'status'];
}
