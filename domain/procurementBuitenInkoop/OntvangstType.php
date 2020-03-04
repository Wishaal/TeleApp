<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class OntvangstType extends Eloquent
{
    public $table = "ontvangst_type";
    protected $primaryKey = 'id';
    protected $fillable = array('type');

}