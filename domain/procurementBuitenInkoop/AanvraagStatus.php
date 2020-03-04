<?php
/**
 * Created by PhpStorm.
 * User: telesur
 * Date: 4/25/2016
 * Time: 1:43 PM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class AanvraagStatus extends Eloquent
{
    public $table = "aanvraagstatus";
    protected $fillable = array('aanvraag_id', 'status_id', 'user_id', 'type');

    public function aanvragen()
    {
        return $this->belongsToMany('Bestelling', 'id', 'aanvraag_id');
    }

    public function getAanvraag()
    {
        return $this->hasOne('Bestelling', 'id', 'aanvraag_id');
    }

    public function getUser()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function getBuitenlandseInkoop()
    {
        return $this->hasOne('BuitenlandseInkoop', 'aanvraag_id', 'aanvraag_id');
    }

    public function getBinnenlandseInkoop()
    {
        return $this->hasOne('BinnenlandseInkoop', 'aanvraag_id', 'aanvraag_id');
    }

    public function getStatus()
    {
        return $this->hasOne('Status', 'id', 'status_id');
    }

}