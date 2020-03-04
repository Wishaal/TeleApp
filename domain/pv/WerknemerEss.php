<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class WerknemerEss extends Eloquent
{
    public $table = "personeel";
    protected $connection = 'ess';
    protected $primaryKey = 'badgenr';
}

