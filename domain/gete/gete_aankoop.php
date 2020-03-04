<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class GETE_AANKOOP extends Eloquent
{
    public $table = "aankoop";
    protected $primaryKey = 'aank_nr';
    protected $fillable = array('aan_nr', 'aan_ond', 'aan_bedri', 'aan_notanr', 'aan_bedr', 'aank_datum', 'aank_omsch');

    /*
    public function getAanvraag(){
        return $this->hasOne('Bestelling','aan_nr','aanvraag_id');
    }
    */
}