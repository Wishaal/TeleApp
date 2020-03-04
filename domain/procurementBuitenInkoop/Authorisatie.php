<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Authorisatie extends Eloquent
{
    public $table = "authorisatie";
    protected $primaryKey = 'id';
    protected $fillable = array('Onderwerp', 'Projectcode', 'grootboekreknr', 'omschrijving', 'valuta', 'bedrag', 'authorisatienr', 'file');

}