<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class WerknemerMySql extends Eloquent
{
    public $table = "registreren.werknemers";
    protected $connection = 'ess';
    protected $primaryKey = 'Code';

    public function personeel()
    {
        return $this->hasOne('WerknemerEss', 'badgenr', 'Code');
    }
}

