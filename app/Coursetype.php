<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Coursetype extends Model
{
    //use LogsActivity;

    protected $table ='course_types';
    protected $guarded =['id'];

    protected static $logAttributes = ['title'];
}
