<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Site extends Eloquent
{
    public $table = "site";
    protected $primaryKey = 'locid';
    protected $fillable = array('locindnr', 'locid', 'locname', 'mobile', 'projectering', 'transmissie', 'adres', 'ressort', 'district', 'towerheight', 'backhaul', 'latitude', 'longitude', 'gsm', 'umts', 'lte', 'transmis', 'opmerking', 'toelichting', 'created_at', 'updated_at', 'created_user', 'updated_user');
}