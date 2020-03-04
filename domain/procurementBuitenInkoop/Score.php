<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Score extends Eloquent
{
    public $table = "score";
    protected $primaryKey = 'id';
    protected $fillable = array('po_nr', 'po_delivery', 'po_bo', 'delivery_po', 'bo_overm', 'delivery_ingekl', 'overm_ingekl', 'shipped_ingekl', 'overm_shipped', 'po_shipped', 'bo_shipped', 'kwaliteit', 'leveringsbetrouwbaarheid', 'score_delivery', 'prijs_score', 'kwaliteit_score', 'leveringsbetrouwbaarheid_score', 'totaal_score', 'extra_info', 'extra_score');

}