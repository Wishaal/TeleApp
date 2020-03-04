<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class SoortOverwerk extends Eloquent
{
    public $table = "stamsoortoverwerk";
    protected $primaryKey = 'soortoverwerknr';
    protected $fillable = array('naam');


}