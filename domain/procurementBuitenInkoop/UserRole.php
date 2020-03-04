<?php
/**
 * Created by PhpStorm.
 * User: telesur
 * Date: 4/25/2016
 * Time: 2:18 PM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserRole extends Eloquent
{
    public $table = "users_roles";
    protected $primaryKey = 'id';
    protected $fillable = array('user_id', 'role_id');

}