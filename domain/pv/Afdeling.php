<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Afdeling extends Eloquent
{
    public $table = "afdeling";
    protected $connection = 'ess';
    protected $primaryKey = 'afdelingcode';
    protected $fillable = array('afdelingnaam','kostenplaatscode','onderdirectoraat');

}