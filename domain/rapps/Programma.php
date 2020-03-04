<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Programma extends Eloquent
{
    public $table = "programma";
    protected $primaryKey = 'programmanr';
    protected $fillable = array('naam', 'hoofd_programmeur','backup_programmeur','analist','doel','productie_datum','afdelingen','relaties','functionaliteiten','productie_servernaam','kritisch_level','ontwikkel_servernaam','eigenaar','applicatie_type');

}

