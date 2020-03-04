<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Project extends Eloquent
{
    public $table = "project";
    protected $primaryKey = 'projectnr';
    protected $fillable = array('naam', 'omschrijving','jaar','begindatum','einddatum','statusnr','code');

}

