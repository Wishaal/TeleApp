<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class EmailUser extends Eloquent
{
    public $table = "email_users";
    protected $primaryKey = 'id';
    protected $fillable = array('email_group_id', 'email', 'omschrijving');

}