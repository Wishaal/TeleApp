<?php
	$menuid = 1;
	//global includes
	require_once('../../php/conf/config.php');
	require_once('../../inc_topnav.php');
	require_once('../../inc_sidebar.php');
	
	//app includes
	require_once('php/config.php');
	
	$action = 'overview';
	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}
	
	switch($action){
		
		default:
		case 'overview':
			
			//logic goes here
			$dataquery = 'SELECT * FROM menuitem';
			$result = $mis_connPDO->query($dataquery);
			$data = array();
			// Parse returned data, and displays them
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
		
			require_once('tmpl/menu-items.tpl.php');
			
		break;
		
		case 'new':
			
			$menuitem = 'SELECT * FROM menuitem';
			$menuitemresultset = $mis_connPDO->query($menuitem);
			$menuitemdata = array();
			// Parse returned data, and displays them
			while($row = $menuitemresultset->fetch(PDO::FETCH_ASSOC)) {
				$menuitemdata[] = $row;
			}
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$active = 0;
				if($_POST['active']) $active = 1;
				$query = "INSERT INTO menuitem (title, link, parent, active, icon, created_at, created_by) 
						  VALUES ('" . $_POST['title'] . "', '" . $_POST['link'] . "', '" . $_POST['parent'] . "', '" . $active . "', 'icon-list.png', GETDATE(), '" . getAppUserId() . "')";
				$resultset = $mis_connPDO->query($query);

				
				header('Location: menu-items.php?msg=saved');
			}
			
			require_once('tmpl/menu-items_new.tpl.php');
			
		break;
		
		case 'edit':
			//logic goes here
			$menuitem = 'SELECT * FROM menuitem';
			$menuitemresultset = $mis_connPDO->query($menuitem);
			$menuitemdata = array();
			// Parse returned data, and displays them
			while($row = $menuitemresultset->fetch(PDO::FETCH_ASSOC)) {
				$menuitemdata[] = $row;
			}
			
			if(isset($_GET['id'])){
					$data = array();
					$query = "SELECT * FROM menuitem WHERE id='". $_GET['id'] . "'";
					$resultset = $mis_connPDO->query($query);
					$data = $resultset->fetch();
			}
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$active = 0;
				if($_POST['active']) $active = 1;
				
				$query_menu_update = "UPDATE menuitem SET 
									title = '" . $_POST['title'] . "' ,
									link = '" . $_POST['link'] . "',
									parent = '" . $_POST['parent'] . "',
									active = '" . $active . "',
									updated_at = GETDATE(),
									updated_by = '" . getAppUserId() . "'
								WHERE id = '" .   $_GET['id'] . "'";
				$resultset_menu_update = $mis_connPDO->query($query_menu_update);				
				
				header('Location: menu-items.php?msg=updated');
				exit();
			}
			
			require_once('tmpl/menu-items_edit.tpl.php');
			
		break;
		
		case 'delete':
			
			if(isset($_GET['id'])){
				$query = "DELETE FROM menuitem WHERE id='". $_GET[id]. "'";
				$resultset = $mis_connPDO->query($query);
			}
			
			header('Location: menu-items.php?msg=deleted');
			
		break;
		
	}
	
?>