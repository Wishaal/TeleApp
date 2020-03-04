<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Filetypen extends Eloquent
{
    public $table = "filetype";
    protected $primaryKey = 'typenr';
    protected $fillable = array('typenr', 'typenaam', 'soort', 'fabrikantids', 'created_at', 'updated_at', 'created_user', 'updated_user');

}