<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 4/18/2016
 * Time: 9:02 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Ontvangst extends Eloquent
{
    public $table = "ontvangst";
    protected $primaryKey = 'id';
    protected $fillable = array('aanvraag_id', 'ontv_datum_ontvangst', 'ontv_gemiddelde_levertijd', 'ontv_oronr', 'ontv_gegevens_van_ontvangst', 'ontv_lokatie_ontvangst',
        'ontv_ontvangen_colli', 'ontv_aantal', 'ontv_seedstock', 'ontv_ontvangen_door', 'ontv_vrachtkosten', 'ontv_aantal_defect', 'ontv_staat_defect',
        'ontv_niet_compleet', 'ontv_opmerkingen', 'ontv_voorbereider', 'ontv_administratie', 'ontv_hoofd_inventory', 'ontv_factuurnummer', 'ontv_factuurbedrag', 'ontv_verwerkt_exact',
        'ontv_datum_exact', 'ontv_keuring', 'ontv_aantal_colli', 'created_user', 'updated_user', 'ontv_deellevering');

    public function deellevering()
    {
        return $this->belongsToMany('Deellevering', 'deellevering', 'record_id', 'id')->withPivot("aantal", "opmerking", "datum");
    }

    public function aanvraagStatus()
    {
        return $this->hasOne('AanvraagStatus', 'aanvraag_id', 'aanvraag_id');
    }

    public function getAanvraag()
    {
        return $this->hasOne('Bestelling', 'id', 'aanvraag_id');
    }

    public function getBinnenlandseInkoop()
    {
        return $this->hasOne('BinnenlandseInkoop', 'aanvraag_id', 'aanvraag_id');
    }

    public function getBuitenlandseInkoop()
    {
        return $this->hasOne('BuitenlandseInkoop', 'aanvraag_id', 'aanvraag_id');
    }

    public function getStatus()
    {
        return $this->hasOne('Status', 'id', 'status_id');
    }

}