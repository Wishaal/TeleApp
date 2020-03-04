<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Werkorder extends Eloquent
{
    public $table = "werkorder";
    protected $primaryKey = 'aanvraagnr';
    protected $fillable = array('aanvraagnr', 'volgnr', 'afdelingcode', 'taaknaam', 'taakverstuurd', 'taakafgemeld', 'aanvraagafgemeld', 'opmerking', 'badgenr', 'created_user', 'updated_user');
}