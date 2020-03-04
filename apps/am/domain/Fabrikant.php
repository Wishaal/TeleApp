<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Fabrikant extends Eloquent
{
    public $table = "fabrikant";
    protected $primaryKey = 'fabrikantid';
    protected $fillable = array('fabrikantid', 'name', 'details', 'contact', 'phone', 'email');

}