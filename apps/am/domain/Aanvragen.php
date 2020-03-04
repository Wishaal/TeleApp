<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Aanvragen extends Eloquent
{
    public $table = "aanvragen";
    protected $primaryKey = 'aanvraagnr';
    protected $fillable = array('aanvraagnr', 'aanvraagdatum', 'statusnr', 'badgenr', 'afdelingcode', 'artikelcode', 'aantal', 'opmerking', 'soortaanvraag', 'created_user', 'updated_user');
}