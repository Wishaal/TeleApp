<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class ScoreInfo extends Eloquent
{
    public $table = "score_info";
    protected $primaryKey = 'id';
    protected $fillable = array('aanvraag_id', 'kwaliteit', 'leveringsbetrouwbaarheid');

}