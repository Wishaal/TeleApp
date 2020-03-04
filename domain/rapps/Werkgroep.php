<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Werkgroep extends Eloquent
{
    public $table = "werkgroep";
    protected $primaryKey = 'werkgroepnr';
    protected $fillable = array('naam', 'omschrijving','begindatum','einddatum');
    protected $guarded = array();

    public function werkgroepDeelnemers()
    {
        return $this->belongsToMany('WerkgroepDeelnemer',"werkgroep_deelnemer","werkgroepnr","badgenr");
    }

}

