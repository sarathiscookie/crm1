<?php

namespace Laraspace;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Orderpositionmeta extends Model
{
    //use LogsActivity;

    protected $table   ='order_position_metas';
    protected $guarded =['id'];

    protected static $logAttributes = ['name', 'value'];
}
