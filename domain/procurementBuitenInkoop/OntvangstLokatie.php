<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class OntvangstLokatie extends Eloquent
{
    public $table = "ontvangst_lokaties";
    protected $primaryKey = 'id';
    protected $fillable = array('lokatie');

}