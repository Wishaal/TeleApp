<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Afdelingaanvr extends Eloquent
{
    public $table = "afdelingaanvr";
    protected $primaryKey = 'id';
    protected $fillable = array('refnr', 'afdeling', 'naam', 'datumtijd', 'kostenplaats', 'auto', 'projnr', 'goedbrief', 'bestover', 'voorbereider', 'manager');

}