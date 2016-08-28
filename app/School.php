<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class School extends Model
{
    //use LogsActivity;

    protected $table ='schools';
    protected $guarded =['id'];

    protected static $logAttributes = ['title', 'alias', 'status', 'duration'];
}
