<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Status extends Eloquent
{
    public $table = "status";
    protected $primaryKey = 'id';
    protected $fillable = array('soort', 'status_omschrijving', 'kenmerk');

}