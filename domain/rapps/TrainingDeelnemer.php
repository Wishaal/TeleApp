<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class TrainingDeelnemer extends Eloquent
{
    public $table = "training_deelnemer";
    protected $primaryKey = 'deelnemernr';
    protected $fillable = array('trainingnr', 'badgenr', 'successvol');

}

