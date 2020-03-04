<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Artikel extends Eloquent
{
    public $table = "artikel";
    protected $primaryKey = 'artikelcode';
    protected $fillable = array('artikelcode', 'artikelnaam', 'hulpstuk', 'minvoorraad', 'created_user', 'updated_user');

}