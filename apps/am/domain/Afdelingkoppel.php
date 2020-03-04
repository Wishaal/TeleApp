<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Afdelingkoppel extends Eloquent
{
    public $table = "afdelingkoppel";
    protected $primaryKey = 'koppelnr';
    protected $fillable = array('koppelnr', 'afdelingcode', 'functienr', 'badgenr', 'created_user', 'updated_user');

}