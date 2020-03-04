<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class DMM_DWH extends Eloquent
{
    public $table = "dmm_dwh";
    protected $primaryKey = 'Caller ID';
}