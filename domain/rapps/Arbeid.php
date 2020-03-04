<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Arbeid extends Eloquent
{
    public $table = "arbeid";
    protected $primaryKey = "arbeidnr";
    protected $fillable = array('maand', 'jaar', 'werkdagen');

}