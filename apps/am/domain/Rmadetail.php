<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Rmadetail extends Eloquent
{
    public $table = "rmadetail";
    protected $primaryKey = 'detailnr';
    protected $fillable = array('detailnr', 'rmavolgnr', 'serienr', 'reserienr', 'created_at', 'updated_at', 'created_user', 'updated_user');
}

