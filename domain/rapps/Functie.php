<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Functie extends Eloquent
{
    public $table = "wrk_functie";
    public $timestamps = false;
    protected $primaryKey = "badgenr";
    protected $fillable = array('badgenr', 'functienr', 'ingangsdatum', 'uitgangsdatum', 'bedrijf');


}

