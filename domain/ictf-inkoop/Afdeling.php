<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Afdeling extends Eloquent
{
    //protected $connection = 'ess';
    public $table = "afdelingen";
    protected $primaryKey = 'af_id';
    protected $fillable = array('af_afdeling','af_afdelingshoofd','af_beschrijving');

}