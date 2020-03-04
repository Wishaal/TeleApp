<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 5/23/2016
 * Time: 3:03 PM
 */

if (isset($_FILES['ingeklaardfileTmp'])) {
    if ($_FILES['ingeklaardfileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('ingeklaardfileTmp', $input, 'documenten/inklaringen/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '10';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}


if (isset($_FILES['vrijstellingfileTmp'])) {
    if ($_FILES['vrijstellingfileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('vrijstellingfileTmp', $input, 'documenten/vrijstelling/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '9';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['bofileTmp'])) {
    if ($_FILES['bofileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('bofileTmp', $input, 'documenten/bo/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '8';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['orofileTmp'])) {
    if ($_FILES['orofileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('orofileTmp', $input, 'documenten/oro/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '7';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['laffileTmp'])) {
    if ($_FILES['laffileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('laffileTmp', $input, 'documenten/laf/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '6';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['contractfileTmp'])) {
    if ($_FILES['contractfileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('contractfileTmp', $input, 'documenten/contract/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '4';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['pofileTmp'])) {
    if ($_FILES['pofileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('pofileTmp', $input, 'documenten/po/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '3';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['authorisatiefileTmp'])) {
    if ($_FILES['authorisatiefileTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('authorisatiefileTmp', $input, 'documenten/authorisaties/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '0';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}

if (isset($_FILES['overmakingbestandTmp'])) {
    if ($_FILES['overmakingbestandTmp']['size'][0] > 0) {
        $array = uploadMultipleFiles('overmakingbestandTmp', $input, 'documenten/overmakingen/');
        foreach ($array as $a) {
            $fileUpload = new FileUpload;
            $fileUpload->aanvraag_id = $_GET['recordId'];
            $fileUpload->upload_type_id = '5';
            $fileUpload->file_path = $a['filepath'];
            $fileUpload->filenaam = $a['filename'];
            $fileUpload->save();
        }
    }
}