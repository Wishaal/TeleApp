<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Leveringsvoorwaarden extends Eloquent
{
    public $table = "leveringsvoorwaarden";
    protected $primaryKey = 'id';
    protected $fillable = array('omschrijving');

}