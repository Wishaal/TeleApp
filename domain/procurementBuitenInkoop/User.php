<?php
/**
 * Created by PhpStorm.
 * User: telesur
 * Date: 4/25/2016
 * Time: 2:16 PM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    public $table = "users";
    protected $primaryKey = 'id';
    protected $fillable = array('username');

    public function userRollen()
    {
        return $this->belongsToMany('Role', 'users_roles', 'user_id', 'role_id');
    }

}