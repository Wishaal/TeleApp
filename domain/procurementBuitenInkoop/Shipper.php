<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Shipper extends Eloquent
{
    public $table = "shipper";
    protected $primaryKey = 'id';
    protected $fillable = array('naam', 'methode', 'land', 'adres', 'contact', 'dagen', 'postsluiting', 'opmerkingen');

}