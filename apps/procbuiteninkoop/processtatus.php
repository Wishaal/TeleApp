<?php
include('php/database.php');
$menuid = menu;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//global includes
require_once('../../php/conf/config.php');
include('php/includes.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//logic goes here

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}


switch ($action) {

    default:
    case 'overview':

        //require_once('tmpl/processtatus.tpl.php');

        break;

    case 'aanvraag';
        //$buitenAll = AanvraagStatus::whereAanvraagId($_POST['search'])->first();
        //echo var_dump($buitenAll);


        //$buitenAll = AanvraagStatus::with('aanvragen')->find('80')->first();
        //echo var_dump($buitenAll);

        $OK = true;
        $data = $_POST['search'];
        $keywords = preg_split('/[\s,]+/', $_POST['search']);

        $search = $keywords;
        $query = AanvraagStatus::query();
        $fields = array(
            'getAanvraag' => ['aanvraag_nr', 'bstl_aanvraag_datum', 'bstl_afdeling', 'bstl_contactpersoon', 'bstl_ingevoerd_door', 'bstl_omschrijving'],
            'getBuitenlandseInkoop' => ['po_nr'],
            'getAanvraag.artikelInfo' => ['artikel'],
        );

// orWhereHas will use joins, so we'll start with fields foreach
        foreach ($fields as $relation => $field) {
            if (is_array($field)) {
                // here we join table for each relation
                $query->orWhereHas($relation, function ($q) use ($field, $search) {

                    // here we need to use nested where like: ... WHERE key = fk AND (x LIKE y OR z LIKE y)
                    $q->where(function ($q) use ($field, $search) {
                        foreach ($field as $relatedField) {
                            foreach ($search as $term) {
                                $q->orWhere($relatedField, 'like', "%{$term}%");
                            }
                        }
                    });
                });
            } else {
                foreach ($search as $term) {
                    $query->orWhere($field, 'like', "%{$term}%");
                }
            }
        }
        $results = $query->get();

        break;


}


require_once('tmpl/processtatus.tpl.php');

?>