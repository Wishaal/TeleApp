<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Valuta extends Eloquent
{
    public $table = "valuta";
    protected $primaryKey = 'valutacode';
    protected $fillable = array('valutacode', 'valutanaam', 'created_user', 'updated_user');

}