<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class OverwerkVerlof extends Eloquent
{
    public $table = "wrk_overwerk";
    protected $primaryKey = 'overwerknr';
    protected $fillable = array('soortoverwerknr', 'badgenr','datum','begintijd','eindtijd','omschrijving','accoord','accoordbadgenr','accoorddatum','aantal','voeding','vervoer');

}

