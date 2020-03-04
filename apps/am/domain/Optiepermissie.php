<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Optiepermissie extends Eloquent
{
    public $table = "optiepermissie";
    protected $primaryKey = 'optienr';
    protected $fillable = array('optienr', 'systeem', 'systeempad', 'optie', 'gebruiker', 'categorie');
}