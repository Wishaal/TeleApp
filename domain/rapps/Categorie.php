<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Categorie extends Eloquent
{
    public $table = "stamcategorie";
    protected $primaryKey = 'categorienr';
    protected $fillable = array('naam');
}