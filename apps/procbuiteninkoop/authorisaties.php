<?php
include('php/database.php');
$menuid = menu;
//global includes
require_once('../../php/conf/config.php');
require_once('php/includes.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':

        break;

    case 'newScore';
        Score::create($input->all());
        $msg = 'saved';
        break;

    case 'updateScore';
        $score = ScoreInfo::firstOrCreate(['aanvraag_id' => $input->input('aanvraag_id')]);
        $score->fill($input->all());
        $score->save();
        $msg = 'updated';
        break;

    case 'new';
        if ($_FILES['authorisatiefileTmp']['name']) {
            if (!$_FILES['authorisatiefileTmp']['error']) {
                $valid_file = true;
                $new_file_name = md5(date('Ymdhis')) . strtolower($_FILES['authorisatiefileTmp']['name']);
                $new_file_name = str_replace(' ', '_', $new_file_name);
                if ($_FILES['authorisatiefileTmp']['size'] > (20971520)) //can't be larger than 20 MB
                {
                    $valid_file = false;
                    $message = 'Oops!  Your file\'s size is to large.';
                }

                if ($valid_file) {
                    move_uploaded_file($_FILES['authorisatiefileTmp']['tmp_name'], 'documenten/authorisaties/' . $new_file_name);
                    $input->merge(array('file' => $new_file_name));
                    $message = 'Congratulations!  Your file was accepted.';
                }

            } //if there is an error...
            else {
                $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['authorisatiefileTmp']['error'];
            }
        }
        Authorisatie::create($input->all());
        $msg = 'saved';
        break;

    case 'update';
        $Authorisatie = Authorisatie::find($_GET['recordId']);
        if ($_FILES['authorisatiefileTmp']['name']) {
            if (!$_FILES['authorisatiefileTmp']['error']) {
                $valid_file = true;
                $new_file_name = md5(date('Ymdhis')) . strtolower($_FILES['authorisatiefileTmp']['name']);
                $new_file_name = str_replace(' ', '_', $new_file_name);
                if ($_FILES['authorisatiefileTmp']['size'] > (20971520)) //can't be larger than 20 MB
                {
                    $valid_file = false;
                    $message = 'Oops!  Your file\'s size is to large.';
                }

                if ($valid_file) {
                    move_uploaded_file($_FILES['authorisatiefileTmp']['tmp_name'], 'documenten/authorisaties/' . $new_file_name);
                    $input->merge(array('file' => $new_file_name));
                    $message = 'Congratulations!  Your file was accepted.';
                }

            } //if there is an error...
            else {
                $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['authorisatiefileTmp']['error'];
            }
        }
        $Authorisatie->fill($input->all());
        $Authorisatie->save();
        $msg = 'updated';
        break;

    case 'delete';
        $Authorisatie = Authorisatie::find($_GET['id']);
        $Authorisatie->delete();

        $msg = 'deleted';
        break;

}
$Authorisatie = Authorisatie::all();
require_once('tmpl/authorisaties.tpl.php');

?>