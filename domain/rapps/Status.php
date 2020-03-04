<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Status extends Eloquent
{
    public $table = "stamstatus";
    protected $primaryKey = 'statusnr';
    protected $fillable = array('naam');

}