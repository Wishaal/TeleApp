<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class AanvraagLog extends Eloquent
{
    public $table = "aanvraag_log";
    protected $primaryKey = 'id';
    protected $fillable = array('aanvraag_id', 'omschrijving', 'gebruiker');

}