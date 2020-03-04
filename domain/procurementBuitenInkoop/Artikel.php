<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Artikel extends Eloquent
{
    public $table = "artikel";
    protected $primaryKey = 'id';
    protected $fillable = array('artikel', 'artikelomschrijving', 'eenheid', 'geleverd', 'jaar');

}