<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 4/18/2016
 * Time: 9:02 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Afgifte extends Eloquent
{
    public $table = "afgifte";
    protected $primaryKey = 'id';
    protected $fillable = array('aanvraag_nr', 'afg_afgerond_mail', 'afg_mab_no', 'afg_verstrekte_colli', 'afg_verstrekkingsdatum', 'afg_ontvangendoor', 'afg_datum_ontv_melding_oro', 'afg_belanghebbende_gemeld', 'afg_keuring', 'afg_verwerkt_in_exact', 'afg_afgifte_stukken_sec', 'afg_presentatie_hoofd', 'afg_documenten_vestuurd', 'afg_opmerkingen', 'created_user', 'updated_user');
}