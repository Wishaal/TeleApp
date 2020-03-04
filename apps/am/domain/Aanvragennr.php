<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Aanvragennr extends Eloquent
{
    public $table = "aanvragennr";
    protected $primaryKey = 'aanvraagnr';
    protected $fillable = array('aanvraagnr');

}