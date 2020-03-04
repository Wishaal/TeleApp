<?php
include('php/config.php');

$menuid = menu;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');


$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
//add domain
include('domain/Rmafile.php');

switch ($action) {
    default:
    case 'overview':
        break;

    case 'new';
        for ($idx = 0; $idx < count($_FILES['fileTmp']['name']); $idx++) {
            if ($_FILES['fileTmp']['name'][$idx]) {
                if (!$_FILES['fileTmp']['error'][$idx]) {
                    $valid_file = true;
                    $new_file_name = $input->rmavolgnr . '_' . $input->multitypenr[$idx] . '_' . date('Ymdhis') . '_' . strtolower($_FILES['fileTmp']['name'][$idx]);
                    $new_file_name = str_replace(' ', '_', $new_file_name);
                    echo $new_file_name . "<br>";
                    if ($_FILES['fileTmp']['size'][$idx] > (20971520)) {
                        $valid_file = false;
                        $message = 'Oops! Your file is to large.';
                    }

                    if ($valid_file) {
                        move_uploaded_file($_FILES['fileTmp']['tmp_name'][$idx], 'documenten/rma/' . $new_file_name);

                        $rmafilerecord = Rmafile::where('rmavolgnr', '=', $input->rmavolgnr)->where('typenr', '=', $input->multitypenr[$idx])->delete();
                        $filedetail = new Rmafile;
                        $filedetail->filenr = '0';
                        $filedetail->rmavolgnr = $input->rmavolgnr;
                        $filedetail->filenaam = $new_file_name;
                        $filedetail->typenr = $input->multitypenr[$idx];
                        $filedetail->created_user = $_SESSION[mis][user][username];
                        $filedetail->created_at = date('Y-m-d h:i:s');
                        $filedetail->save();
                        $message = 'Congratulations! Your file was accepted.';
                        $msg = 'saved';
                    }
                } else {
                    $message = 'Oops! Your upload triggered the following error:  ' . $_FILES['fileTmp']['error'][$idx];
                }
            }
        }
        die('<script type="text/javascript">window.location.href="' . $_GET['parent'] . '.php";</script>');
        break;

    case 'update';
        $Rmafile = Rmafile::find($_GET['recordId']);
        $Rmafile->fill($input->all());
        $Rmafile->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Rmafile = Rmafile::find($_GET['id']);
        $Rmafile->delete();

        $msg = 'deleted';
        break;
}
$Rmafile = Rmafile::all();
$templatefilenaam = 'tmpl/Rmafile.tpl.php';
if (file_exists($templatefilenaam)) {
    require_once($templatefilenaam);
} else {
    die('File does NOT exists');
}
?>