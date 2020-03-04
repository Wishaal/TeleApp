<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Shipping extends Eloquent
{
    public $table = "shipping";
    protected $primaryKey = 'id';
    protected $fillable = array('methode');

}