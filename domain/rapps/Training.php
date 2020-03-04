<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class Training extends Eloquent
{
    public $table = "training";
    protected $primaryKey = 'trainingnr';
    protected $fillable = array('naam', 'omschrijving','begindatum','einddatum','bedrijfnr','trainer','locatie');
    protected $guarded = array();

    public function trainingDeelnemers()
    {
        return $this->belongsToMany('TrainingDeelnemer',"training_deelnemer","trainingnr","badgenr")->withPivot("successvol");
    }

}

