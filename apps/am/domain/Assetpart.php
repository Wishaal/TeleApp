<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Assetpart extends Eloquent
{
    public $table = "assetpart";
    protected $primaryKey = 'assetpartnr';
    protected $fillable = array('assetpartnr', 'assetnaam', 'artikelcode', 'serienr', 'partnr', 'revisioncode', 'categorienr', 'garantiedatumbegin', 'garantiedatumeind', 'oronr', 'opmerking', 'vendorcode', 'fabrikantid', 'valutacode', 'aantal', 'prijs', 'statusnr', 'return_opm', 'created_user', 'updated_user');


}