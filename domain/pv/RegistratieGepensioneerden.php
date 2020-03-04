<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class RegistratieGepensioneerden extends Eloquent
{
    public $table = "registratiegepensioneerden";
    protected $primaryKey = 'id';
    protected $fillable = array('naam', 'voornaam', 'partner', 'maat1', 'maat2', 'instaplocatie', 'weduwe', 'opmerkingen', 'created_by');

}