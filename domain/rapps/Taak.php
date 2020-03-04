<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Taak extends Eloquent
{
    public $table = "stamtaak";
    protected $primaryKey = 'taaknr';
    protected $fillable = array('naam');

}