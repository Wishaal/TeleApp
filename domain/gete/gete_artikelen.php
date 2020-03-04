<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class GETE_ARTIKELEN extends Eloquent
{
    public $table = "artikelen";
    protected $primaryKey = 'art_aank_nr';
    protected $fillable = array('art_volg', 'art_aank_nr', 'art_nr', 'art_omsch', 'art_hoeveel', 'art_afdeling', 'art_locatie', 'art_bedrag');

    /*
    public function getAanvraag(){
        return $this->hasOne('Bestelling','aan_nr','aanvraag_id');
    }
    */
}