<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Membership extends Model
{
    //use LogsActivity;

    protected $table ='memberships';
    protected $guarded =['id'];
    public $timestamps = false;

    protected static $logAttributes = ['customer_id', 'school_id', 'joined_at', 'renewed_at', 'cancelled_at'];
}
