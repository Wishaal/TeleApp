<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

include 'database.php';
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class RegistratieTemplate3 extends Eloquent
{
    public $table = "registreren.registratietemplate3";
    protected $connection = 'ess';
    protected $primaryKey = 'id';
    protected $fillable = array('badgenr','naam','voornaam','emailadres','mobiel','afdeling','partner','dienstjaren','opmerking');

}

