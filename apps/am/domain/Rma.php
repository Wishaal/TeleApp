<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Rma extends Eloquent
{
    public $table = "rma";
    protected $primaryKey = 'rmavolgnr';
    protected $fillable = array('rmavolgnr', 'rmanr', 'reqdatum', 'fabrikantid', 'partnr', 'productname', 'garantie', 'siteid', 'oronr', 'rpnr', 'awbnr', 'aantal', 'shipdatum', 'recdatum', 'filefaulty', 'fileacknow', 'orderacknr', 'swnr', 'ernr', 'prijs', 'opmerking', 'statusnr', 'created_at', 'updated_at', 'created_user', 'updated_user');
}