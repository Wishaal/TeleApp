<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Landen extends Eloquent
{
    public $table = "country";
    protected $primaryKey = 'id';
    protected $fillable = array('iso3', 'nicename');

}