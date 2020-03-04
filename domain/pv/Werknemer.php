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
    public $table = "werknemers";
    protected $primaryKey = 'Code';

}

