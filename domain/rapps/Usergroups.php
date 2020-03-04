<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Usergroups extends Eloquent
{
    public $table = "usergroups";
    protected $connection = 'rappframework';
    protected $primaryKey = 'id';
    protected $fillable = array('name', 'description', 'relatedmenu');

}