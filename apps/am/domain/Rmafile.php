<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Rmafile extends Eloquent
{
    public $table = "rmafile";
    protected $primaryKey = 'filenr';
    protected $fillable = array('filenr', 'rmavolgnr', 'typenr', 'filenaam', 'created_at', 'updated_at', 'created_user', 'updated_user');
}

