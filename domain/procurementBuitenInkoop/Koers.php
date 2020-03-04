<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Koers extends Eloquent
{
    public $table = "koers";
    protected $primaryKey = 'id';
    protected $fillable = array('usd_koers', 'euro_koers', 'omrekeningskoers', 'datum');

}