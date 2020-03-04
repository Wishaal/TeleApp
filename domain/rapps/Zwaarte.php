<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Zwaarte extends Eloquent
{
    public $table = "stamzwaarte";
    protected $primaryKey = 'zwaartenr';
    protected $fillable = array('naam');

}