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
    //protected $connection = 'ess';
    public $table = "statussen";
    protected $primaryKey = 'st_id';
    protected $fillable = array('st_naam', 'st_omsch');

}