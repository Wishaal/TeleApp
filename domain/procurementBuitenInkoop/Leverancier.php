<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Leverancier extends Eloquent
{
    public $table = "leverancier";
    protected $primaryKey = 'id';
    protected $fillable = array('name', 'details', 'contact', 'phone', 'fax', 'email');

}