<?php
/**
 * Created by PhpStorm.
 * User: telesur
 * Date: 4/25/2016
 * Time: 2:16 PM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent
{
    public $table = "roles";
    protected $primaryKey = 'id';
    protected $fillable = array('rolnaam');


    public function users()
    {
        return $this->hasMany('UserRole', 'role_id', 'id');
    }

}