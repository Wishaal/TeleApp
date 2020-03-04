<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Inlog extends Eloquent
{
    public $table = "inlog";
    protected $primaryKey = "inlognr";
    protected $fillable = array('naam', 'gebruikersnaam', 'wachtwoord', 'adres', 'instructie');

}