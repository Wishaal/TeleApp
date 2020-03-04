<?php
	$menuid = 1;
	//global includes
	require_once('../../php/conf/config.php');
	require_once('../../inc_topnav.php');
	require_once('../../inc_sidebar.php');
	
	$action = 'overview';
	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}
	
	function ruleExists($usergroupid, $menuid){
		$mis_connPDO = new PDO("sqlsrv:Server=; Database=;",null, null);
		$mis_connPDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$usermenu_query = 'SELECT * FROM permission WHERE menunr = '. $menuid .' AND usergroup_id = '. $usergroupid .'';
		$usermenu_res = $mis_connPDO->query($usermenu_query);
		$data = array();
		// Parse returned data, and displays them
		while($row = $usermenu_res->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $row;
		}
		
		if($data){
			return true;
		} else {
			return false;
		}	
	}
	
	$permissionquery = 'SELECT * FROM permission';
	$permissionresultset = $mis_connPDO->query($permissionquery);
	$permissiondata = array();
	// Parse returned data, and displays them
	while($row = $permissionresultset->fetch(PDO::FETCH_ASSOC)) {
		$permissiondata[] = $row;
	}
	
	/* function getPermission($permissiondata, $usergroupid, $menuid, $permission){
		
		foreach($permissiondata as $item){
			if($item['usergroup_id'] == $usergroupid && $item['menunr'] == $menuid && $item['permission_' . $permission] == 1){
				return true;
			} 
		}
		return false;
	} */
	
	function getPermission($permissiondata, $usergroupid, $menuid, $permission){
		
		for ($i = 0; $i < count($permissiondata); ++$i) {
		//foreach($permissiondata as $item){
			if($permissiondata[$i]['usergroup_id'] == $usergroupid && $permissiondata[$i]['menunr'] == $menuid && $permissiondata[$i]['permission_' . $permission] == 1){
				return true;
			} 
		}
		return false;
	}
	
	/*echo '<pre>';
	//print_r($permissiondata);
	print_r(getPermission($permissiondata, 16, 1, 'update'));
	echo '</pre>';
	exit();*/
	
	switch($action){
		
		default:
		case 'overview':
			$dataquery = 'SELECT * FROM usergroups';
			$dataresultset = $mis_connPDO->query($dataquery);
			$data = array();
			// Parse returned data, and displays them
			while($row = $dataresultset->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
		
			require_once('tmpl/permissies.tpl.php');
			
		break;
		
		case 'edit':

			$menus = querySelectPDO($mis_connPDO, 'SELECT id,title FROM menuitem where parent=0');
			
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$menuitem = "select * from menuitem where id = '".$_POST['menuid']."' or parent in
							(select id from menuitem where id = '".$_POST['menuid']."' or parent='".$_POST['menuid']."')";
				//echo $menuitem;
				$menuitemresultset = $mis_connPDO->query($menuitem);
				$menuitemdata = array();
				// Parse returned data, and displays them
				while($row = $menuitemresultset->fetch(PDO::FETCH_ASSOC)) {
					$menuitemdata[] = $row;
				}

				$usergroup_id = $_GET['id'];
				
				if($_POST['permission']){
					foreach($_POST['permission'] as $key => $menupermission){
						
						$menuid = $key;
						
						//check if user-menu record exists
						
						if(ruleExists($usergroup_id, $menuid)){
							
							$query = "UPDATE permission SET
											permission_select = '" . $menupermission['select'] . "' ,
											permission_insert = '" . $menupermission['insert'] . "',
											permission_update = '" . $menupermission['update'] . "',
											permission_delete = '" . $menupermission['delete'] . "',
											permission_other = '" . $menupermission['other'] . "',
											updated_at = GETDATE(),
											updated_by = '" . getAppUserId() . "'
										WHERE usergroup_id = '" .   $usergroup_id . "' AND menunr = '" .   $menuid . "'";
							$menuitemresultset = $mis_connPDO->query($query);
						} else {
							
							$query = "INSERT INTO permission (menunr, usergroup_id, permission_select, permission_insert, permission_update, permission_delete, permission_other, created_at, created_by) VALUES ('" .   $menuid . "', '" .   $usergroup_id . "', '" . $menupermission['select'] . "', '" . $menupermission['insert'] . "', '" . $menupermission['update'] . "', '" . $menupermission['delete'] . "', '" . $menupermission['other'] . "', GETDATE(), '" . getAppUserId() . "')";
							$menuitemresultset = $mis_connPDO->query($query);
						}
					}

					header('Location: permissies.php?msg=updated');
					exit();
				}
				

			}
			
			require_once('tmpl/permissies_edit.tpl.php');
			
		break;
		
	}
	
?>