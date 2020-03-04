<?php
/**
 * Created by PhpStorm.
 * User: mathmis
 * Date: 2/22/2016
 * Time: 1:11 PM
 */
include('../php/database.php');
include('../php/functions.php');
include('../../../domain/procurementBuitenInkoop/FileUpload.php');

$file = FileUpload::find($_GET['id']);
$file->delete();
//move deleted file xD
rename("../" . $file->file_path . $file->filenaam, "../documenten/deleted/" . $file->filenaam);

?>