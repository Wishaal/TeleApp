<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Aanvragenparts extends Eloquent
{
    public $table = "aanvragenparts";
    protected $primaryKey = 'aanvpartnr';
    protected $fillable = array('aanvpartnr', 'aanvraagnr', 'serienr', 'rbadgenr', 'dbadgenr', 'opmerking', 'created_user', 'updated_user');

}