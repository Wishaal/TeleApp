<?php

/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 11/26/2015
 * Time: 10:41 AM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;

class FileUpload extends Eloquent
{
    public $table = "file_uploads";
    protected $primaryKey = 'id';
    protected $fillable = array('aanvraag_id', 'upload_type_id', 'file_path', 'filenaam');

    public function getUploadType()
    {
        return $this->hasOne('UploadType', 'id', 'upload_type_id');
    }

}