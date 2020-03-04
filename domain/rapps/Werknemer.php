<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Werknemer extends Eloquent
{
    public $table = "wrk";
    protected $primaryKey = 'badgenr';
    protected $fillable = array('id', 'badgenr','naam','voornaam','geboortedatum','geslacht','extern');

    public function functie()
    {
        return $this->hasOne('Functie', 'badgenr','badgenr');
    }

}

