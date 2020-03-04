<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Categorie extends Eloquent
{
    public $table = "categorie";
    protected $primaryKey = 'categorienr';
    protected $fillable = array('categorienr', 'categorienaam', 'parentnr', 'afkcode', 'created_user', 'updated_user');

}