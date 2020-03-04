<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Deellevering extends Eloquent
{
    public $table = "deellevering";
    protected $primaryKey = 'dl_id';
    protected $fillable = array('record_id', 'aanvraag_id', 'aantal', 'opmerking', 'datum');

}