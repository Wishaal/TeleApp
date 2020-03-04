<?php

$query = '	SELECT * 
				FROM menuitem 
				WHERE id 
				IN (SELECT p.menunr FROM permission AS p WHERE usergroup_id IN ( SELECT x.usergroup_id FROM user_group AS x WHERE user_id = \'' . $_SESSION['mis']['user']['id'] . '\' ) AND permission_select = \'1\')
				AND parent = \'0\'
				AND active = \'1\'';

$result = $mis_connPDO->query($query);
$topnav_items = array();
// Parse returned data, and displays them
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $topnav_items[] = $row;
}

/*echo '<pre>';
var_dump($_SESSION['mis']['user']);
echo '</pre>';*/

?>