<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class District extends Eloquent
{
    public $table = "district";
    protected $primaryKey = 'district_id';
    protected $fillable = array('district_code', 'district_naam', 'district_cruser', 'district_chuser');

}