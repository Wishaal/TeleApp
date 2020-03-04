<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Afdeling extends Eloquent
{
    public $table = "afdeling";
    protected $primaryKey = 'afdelingcode';
    protected $fillable = array('afdelingcode', 'afdelingnaam', 'kostenplaatscode', 'onderdirectoraat', 'created_user', 'updated_user');

}