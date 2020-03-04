<?php

/**
 * Created by PhpStorm.
 * User: jasamis
 * Date: 04/09/2016
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class Project extends Eloquent
{
    public $table = "project";
    protected $primaryKey = 'projectcode';
    protected $fillable = array('projectcode', 'parentprojectcode', 'projectnaam', 'created_user', 'updated_user');

}