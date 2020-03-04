<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Activiteit extends Eloquent
{
    public $table = "activiteit";
    protected $primaryKey = 'activiteitnr';
    protected $fillable = array('jaar', 'naam', 'omschrijving', 'actviteitcode', 'programmanr', 'statusnr',
        'zwaartenr', 'afdelingscode', 'geplandedagen', 'startdatum', 'planningsdatum', 'wijzigingsdatum', 'wijzigingsopmerking', 'realisatiedatum',
        'code', 'opmerking', 'projectnr');

}