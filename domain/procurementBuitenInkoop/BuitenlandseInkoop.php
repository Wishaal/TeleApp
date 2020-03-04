<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class BuitenlandseInkoop extends Eloquent
{
    public $table = "buitenlandseinkoop";
    protected $primaryKey = 'id';
    protected $fillable = array('aanvraag_id', 'po_nr', 'po_bestand', 'cof_nr', 'contract_bestand', 'factuur_datum', 'afdeling', 'kostenplaats', 'leverancier_id', 'omschrijving', 'valuta', 'bedrag', 'authorisatienr', 'authorisatie_saldo', 'po_datum'
    , 'betalingsvoorwaarden', 'delivery', 'leveringsvoorwaarden', 'bo', 'bo_bestand', 'deelbetaling', 'overmakingdatum', 'overmakingbestand', 'vrijstelling', 'vrijstelling_bestand', 'laf_bestand', 'laf_nummer', 'shipping_date', 'shipped_from', 'shipping_method', 'shipping_estimated_delivery'
    , 'ingeklaard_datum', 'ingeklaard_bestand', 'deellevering', 'ingeklaard_oro_nummer', 'oro_bestand', 'ingeklaard_opmerking', 'datumomrekeningsfactor', 'Tussenkoers', 'doorsturen', 'eenheidprijs', 'korting_in_bedrag', 'aantalStuks', 'transkosten', 'transvaluta', 'transaantal', 'transeenheid');

    public function deelbetalingen()
    {
        return $this->belongsToMany('Deelbetaling', 'deelbetaling', 'record_id', 'id')->withPivot("deel_bo_nummer", "deel_bo_datum", "status_id", "betalingsvoorwaarden_id", "deel_valuta", "bedrag_deel");
    }

    public function deellevering()
    {
        return $this->belongsToMany('Deellevering', 'deellevering', 'record_id', 'id')->withPivot("aantal", "opmerking");
    }

    public function getAanvraag()
    {
        return $this->hasOne('Bestelling', 'id', 'aanvraag_id');
    }

    public function getOntvangstBuitenlandseInkoop()
    {
        return $this->hasOne('Ontvangst', 'aanvraag_id', 'aanvraag_id');
    }

    public function getLeverancier()
    {
        return $this->hasOne('Leverancier', 'id', 'leverancier_id');
    }

    public function getLeveringsvoorwaarden()
    {
        return $this->hasOne('Leveringsvoorwaarden', 'id', 'leveringsvoorwaarden');
    }

    public function getBetalingsvoorwaarden()
    {
        return $this->hasOne('Betalingsvoorwaarde', 'id', 'betalingsvoorwaarden');
    }

    public function getScoreExtra()
    {
        return $this->hasOne('ScoreInfo', 'aanvraag_id', 'aanvraag_id');
    }
}