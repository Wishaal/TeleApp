<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Deelbetaling extends Eloquent
{
    public $table = "deelbetaling";
    protected $primaryKey = 'db_id';
    protected $fillable = array('record_id', 'aanvraag_id', 'deel_bo_nummer', 'deel_bo_datum', 'betalingsvoorwaarden_id', 'status_id', 'deel_valuta', 'bedrag_deel');

}