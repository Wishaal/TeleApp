<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Bestelbon extends Eloquent
{
    //protected $connection = 'ess';
    public $table = "bestelbon";
    protected $primaryKey = 'id';
    protected $fillable = array('datum_verzonden', 'ponr', 'v_id', 'refnr', 'bd_id', 'omschrijving', 'st_id', 'bedrag', 'opmerking', 'mail');

    public function getBedrijf()
    {
        return $this->hasOne('Bedrijf', 'bd_id', 'bd_id');
    }

    public function getStatus()
    {
        return $this->hasOne('Status', 'st_id', 'st_id');
    }

    public function getValuta()
    {
        return $this->hasOne('Valuta', 'id', 'v_id');
    }
}