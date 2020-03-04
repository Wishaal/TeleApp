<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class StamFunctie extends Eloquent
{
    public $table = "stamfunctie";
    protected $primaryKey = "functienr";
    protected $fillable = array('naam');

}

