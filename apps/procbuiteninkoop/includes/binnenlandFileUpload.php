<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 5/23/2016
 * Time: 3:04 PM
 */

if (isset($_FILES['offertefileTmp'])) {
    if ($_FILES['offertefileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('offertefileTmp', $input, 'documenten/offertes/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '1';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['prijs_vergfileTmp'])) {
    if ($_FILES['prijs_vergfileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('prijs_vergfileTmp', $input, 'documenten/prijsvergelijkingen/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '2';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['bestelbonfileTmp'])) {
    if ($_FILES['bestelbonfileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('bestelbonfileTmp', $input, 'documenten/bestelbonnen/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '13';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}