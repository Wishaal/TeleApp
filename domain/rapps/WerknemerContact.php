<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:26 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class WerknemerContact extends Eloquent
{
    public $table = "wrk_contact";
    public $timestamps = false;
    protected $primaryKey = 'badgenr';
    protected $fillable = array('badgenr', 'interntel', 'email', 'mobiel', 'telesurcircle', 'gebruikersnaam', 'pcnr', 'adres', 'huistel', 'opmerking', 'soortgebruiker');
}