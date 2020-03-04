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

class RegistratieTemplate4 extends Eloquent
{

    public $table = "registratietemplate4";
    protected $primaryKey = 'id';
    protected $fillable = array('badgenr', 'naam', 'voornaam', 'emailadres', 'partner', 'aanwezig', 'created_by');

}

