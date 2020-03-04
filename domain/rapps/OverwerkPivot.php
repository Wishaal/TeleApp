<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use DB;

class OverwerkPivot extends Eloquent
{
    public static function getTest()
    {
        return Capsule::statement("call sp_overwerkverlof('2016-01-01','2016-01-30')");
    }
}

