<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/18/2015
 * Time: 11:23 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\Request as Request;

class RegistratieTemplate1 extends Eloquent
{
    public $table = "registratietemplate1";
    protected $primaryKey = 'id';
    protected $fillable = array('activiteit', 'badgenr', 'naam', 'voornaam', 'emailadres', 'mobiel', 'lid_pv', 'totaal_personen', 'zelf_mee', 'gezin_mee', 'introducees_mee', 'k_s', 'k_m', 'k_l', 'xs', 's', 'm', 'l', 'xl', 'xxl', 'xxxl', 'betaling_salarisinhouding', 'voeding_1', 'voeding_2', 'voeding_3', 'voeding_4', 'opmerking');

}

