<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Valuta extends Eloquent
{
    public $table = "stamvaluta";
    protected $primaryKey = 'valutanr';
    protected $fillable = array('naam');

}