<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Personeel extends Eloquent
{
    public $table = "personeel";
    protected $primaryKey = 'badgenr';
    protected $fillable = array('badgenr', 'naam', 'voornaam', 'afdelingcode', 'emailadres', 'created_user', 'updated_user');

}