<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Hotel extends Model
{
    //use LogsActivity;

    protected $table ='hotels';
    protected $guarded =['id'];

    protected static $logAttributes = ['title', 'nights', 'additional_nights', 'status'];
}
