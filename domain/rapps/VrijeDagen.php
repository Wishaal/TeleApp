<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class VrijeDagen extends Eloquent
{
    public $table = "stamvrijedag";
    protected $fillable = array('naam', 'vrijedag');

}