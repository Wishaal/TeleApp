<?php
	
	//get the active menu item
	//$pageurl = array_pop(explode('/', $_SERVER['PHP_SELF']));
	$url_segments = array_reverse(explode('/', $_SERVER['PHP_SELF']));
	$pageurl = $url_segments[1] . '/' . $url_segments[0];	
	
	if(strstr($_SERVER['PHP_SELF'], 'aob_native')){
		$pageurl = array_pop(explode('/', $_SERVER['PHP_SELF'])) . (!empty($_SERVER['QUERY_STRING']) ? '?' : '' ) . $_SERVER['QUERY_STRING'];	
	}
	$activemenuitem = querySelectPDO($mis_connPDO, 'SELECT * FROM menuitem WHERE link LIKE (\'%' . $pageurl . '%\')');
	$parentItem = querySelectPDO($mis_connPDO, 'SELECT * FROM menuitem WHERE id = \'' . $activemenuitem['parent'] . '\'');
	$appItem = querySelectPDO($mis_connPDO, 'SELECT * FROM menuitem WHERE id = \'' . $parentItem['parent'] . '\'');
	
	//load the items for the breadcrumb
	$breadcrumbArray = array();
	$breadcrumbArray[] = array( 'title' => 'Home', 'url' => 'main.php' );
	$breadcrumbArray[] = array( 'title' => $appItem['title'], 'url' => $appItem['link'] );
	$breadcrumbArray[] = array( 'title' => $parentItem['title'], 'url' => $parentItem['link'] );
	$breadcrumbArray[] = array( 'title' => $activemenuitem['title'], 'url' => $activemenuitem['link'] );
	
	/*echo '<pre>';
	print_r($activemenuitem);
	print_r($breadcrumbArray);
	echo '</pre>';*/

	
	$query = '	SELECT * 
				FROM menuitem 
				WHERE 
				parent = \''. $menuid .'\'
				AND id IN (SELECT p.menunr FROM permission AS p WHERE usergroup_id IN ( SELECT x.usergroup_id FROM user_group AS x WHERE user_id = \''. $_SESSION['mis']['user']['id'] .'\' ) AND permission_select = \'1\')
				AND active = \'1\'
				ORDER BY ordering ASC';
				
	$result = $mis_connPDO->query($query);
	
	$sidebar_items = array();
	// Parse returned data, and displays them
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	  $sidebar_items[] = $row;
	}
	
	//get subitems
	$count = 0;
	foreach($sidebar_items as $i){

		$subquery = '	SELECT * 
				FROM menuitem 
				WHERE 
				parent = \''. $i['id'] .'\'
				AND id IN (SELECT p.menunr FROM permission AS p WHERE usergroup_id IN ( SELECT x.usergroup_id FROM user_group AS x WHERE user_id = \''. $_SESSION['mis']['user']['id'] .'\' ) AND permission_select = \'1\')
				AND active = \'1\'
				ORDER BY ordering ASC';
				
		$result1 = $mis_connPDO->query($subquery);
	
	// Parse returned data, and displays them
	while($row = $result1->fetch(PDO::FETCH_ASSOC)) {
	  //permission check for native menu.
			$row['selectpermissie'] = 1;
			if(!empty($row['native_menunr'])){
				$p = querySelectPDO($aob_conn, "SELECT selectpermissie FROM permissie WHERE menunr = '" . $row['native_menunr'] . "' AND badgenr = '" . getAppUserBadgenr() . "'");
				$row['selectpermissie'] = $p['selectpermissie'];
			}
			$sidebar_items[$count]['sub'][] = $row;
	}	
		$count++;
	}
?>