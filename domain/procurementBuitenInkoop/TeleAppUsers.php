<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class TeleAppUsers extends Eloquent
{
    public $table = "users";
    protected $connection = 'teleapp';
    protected $primaryKey = 'id';

}