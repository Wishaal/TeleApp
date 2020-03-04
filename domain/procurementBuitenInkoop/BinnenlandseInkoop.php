<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class BinnenlandseInkoop extends Eloquent
{
    public $table = "inbehandeling_verwerking";
    protected $primaryKey = 'id';
    protected $fillable = array('betaling_status_id', 'aanvraag_id', 'inbver_doorsturen', 'inbver_offerte_opvraag_datum', 'inbver_offertes_datum', 'inbver_bestelbonnr', 'inbver_offertenummer', 'inbver_prijsvergelijking_datum', 'authorisatie_id', 'inbver_valuta', 'inbver_bedrag', 'inbver_saldo', 'inbver_getekende_bestelbon_datum', 'leverancier_id', 'betalingsvoorwaarden', 'leveringsvoorwaarden', 'inbver_valuta_eenheidprijs', 'inbver_eenheidprijs', 'inbver_korting_in_proc', 'inbver_korting_in_bedrag', 'inbver_aantal', 'inbver_totaal_te_betalen', 'inbver_getekende_bestelbon_dir_datum', 'inbver_levering_bestelbon_datum', 'inbver_co_logistiek', 'inbver_hoofd_inventory', 'inbver_opmerkingen');


    public function deelbetalingen()
    {
        return $this->belongsToMany('Deelbetaling', 'deelbetaling', 'record_id', 'id')->withPivot("status_id", "betalingsvoorwaarden_id", "bedrag");
    }

    public function deellevering()
    {
        return $this->belongsToMany('Deellevering', 'deellevering', 'record_id', 'id')->withPivot("aantal", "opmerking");
    }

    public function getOntvangstBinnenlandseInkoop()
    {
        return $this->hasOne('Ontvangst', 'aanvraag_id', 'aanvraag_id');
    }

    public function getLeverancier()
    {
        return $this->hasOne('Leverancier', 'id', 'leverancier_id');
    }
}