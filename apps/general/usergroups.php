<?php
$menuid = 1;
//global includes
require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');

//app includes
require_once('php/config.php');

$action = 'overview';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    default:
    case 'overview':

        //logic goes here
        $dataquery = 'SELECT * FROM usergroups';
        $dataresultset = $mis_connPDO->query($dataquery);
        $data = array();
        // Parse returned data, and displays them
        while ($row = $dataresultset->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        require_once('tmpl/usergroups.tpl.php');

        break;

    case 'new':

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $active = 0;
            if ($_POST['active']) $active = 1;
            $query = "INSERT INTO usergroups (name, description, created_at, created_by) 
								VALUES ('" . $_POST['name'] . "', '" . $_POST['description'] . "', GETDATE(), '" . getAppUserId() . "')";
            $dataresultset = $mis_connPDO->query($query);

            header('Location: usergroups.php?msg=saved');
        }

        require_once('tmpl/usergroups_new.tpl.php');

        break;

    case 'edit':

        if (isset($_GET['id'])) {
            $query = "SELECT * FROM usergroups WHERE id='" . $_GET['id'] . "'";
            $resultset = $mis_connPDO->query($query);
            $data = $resultset->fetch();

        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $active = 0;
            if ($_POST['active']) $active = 1;
            $query = "	UPDATE usergroups SET 
									name = '" . $_POST['name'] . "' ,
									description = '" . $_POST['description'] . "',
									updated_at = GETDATE(),
									updated_by = '" . getAppUserId() . "'
								WHERE id = '" . $_GET['id'] . "'";
            $resultset = $mis_connPDO->query($query);

            header('Location: usergroups.php?msg=updated');
            exit();
        }

        require_once('tmpl/usergroups_edit.tpl.php');

        break;

    case 'delete':

        if (isset($_GET['id'])) {

            $usergroupdata = querySelectPDO($mis_connPDO, 'SELECT * FROM user_group WHERE usergroup_id = \'' . $_GET['id'] . '\'');
            if (!empty($usergroupdata)) {
                header('Location: usergroups.php?msg=delete-failed');
                exit();
            } else {
                $query = "DELETE FROM usergroups WHERE id='" . $_GET[id] . "'";
                $resultset = $mis_connPDO->query($query);

                header('Location: usergroups.php?msg=deleted');
                exit();
            }

        }

        break;

}

?>