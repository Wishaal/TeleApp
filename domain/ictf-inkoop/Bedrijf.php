<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Bedrijf extends Eloquent
{
    //protected $connection = 'ess';
    public $table = "bedrijven";
    protected $primaryKey = 'bd_id';
    protected $fillable = array('bd_naam','bd_tel','bd_adres','bd_email','bd_omsch');

}