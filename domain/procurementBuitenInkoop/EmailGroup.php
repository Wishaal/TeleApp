<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class EmailGroup extends Eloquent
{
    public $table = "email_groups";
    protected $primaryKey = 'id';
    protected $fillable = array('name');

    public function Users()
    {
        return $this->belongsToMany('EmailUser', 'email_users', 'email_group_id', 'email')->withTimestamps();
    }

    public function mailUsers()
    {
        return $this->hasMany('EmailUser', 'email_group_id', id);
    }
}