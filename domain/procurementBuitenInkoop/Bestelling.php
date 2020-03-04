<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 4/18/2016
 * Time: 9:02 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Bestelling extends Eloquent
{
    public $table = "aanvraags";
    protected $primaryKey = 'id';
    protected $fillable = array('aanvraag_nr', 'authorisatie_id', 'bstl_aanvraag_datum', 'bstl_afdeling', 'bstl_contactpersoon', 'bstl_ingevoerd_door', 'bstl_tbv', 'bstl_artikelcode', 'bstl_omschrijving', 'bstl_te_bestellen', 'bstl_eenheid', 'bstl_huidig_voorraad', 'bstl_verbruik_voorgaand_jr', 'bstl_opmerkingen', 'bstl_co_logistiek', 'bstl_voorbereider', 'bstl_hoofd_inventory', 'inbox_terug_opmerking', 'created_user', 'updated_user');

    public function aanvraagStatus()
    {
        return $this->hasOne('AanvraagStatus', 'aanvraag_id', 'id');
    }

    public function artikelInfo()
    {
        return $this->hasOne('Artikel', 'id', 'bstl_artikelcode');
    }

}

