<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Statustype extends Eloquent
{
    public $table = "statustype";
    protected $primaryKey = 'statusnr';
    protected $fillable = array('statusnr', 'statusnaam', 'created_user', 'updated_user');

}