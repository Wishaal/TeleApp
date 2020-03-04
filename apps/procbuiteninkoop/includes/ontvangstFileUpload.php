<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 5/23/2016
 * Time: 3:04 PM
 */

if (isset($_FILES['orofileTmp'])) {
    if ($_FILES['orofileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('orofileTmp', $input, 'documenten/oro/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $bestelling->id;
            $fileUpload->upload_type_id = '7';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['airwayfileTmp'])) {
    if ($_FILES['airwayfileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('airwayfileTmp', $input, 'documenten/airway/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $bestelling->id;
            $fileUpload->upload_type_id = '11';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}
if (isset($_FILES['factuurfileTmp'])) {
    if ($_FILES['factuurfileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('factuurfileTmp', $input, 'documenten/factuur/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $bestelling->id;
            $fileUpload->upload_type_id = '12';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}