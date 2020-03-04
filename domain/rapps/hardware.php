<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Hardware extends Eloquent
{
    public $table = "hardware";
    protected $primaryKey = "hardwarenr";
    protected $fillable = array('naam', 'soort', 'ipadres', 'locatie', 'status', 'omschrijving');

}