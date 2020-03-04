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
			if (isset($_POST['group']))
			{$dataquery = "SELECT users.id,users.username,users.email,users.badge,users.status, users.afd,users.name FROM users,user_group where users.id=user_group.user_id and user_group.usergroup_id='" . $_POST['group'] . "'";
			} else {
			$dataquery = "SELECT * FROM users";
			}	
			$dataresultset = $mis_connPDO->query($dataquery);
			$data = array();
			// Parse returned data, and displays them
			while($row = $dataresultset->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
		
			require_once('tmpl/users.tpl.php');
			
		break;
		
		case 'new':
			
			$usergroups = querySelectPDO($mis_connPDO, 'SELECT * FROM usergroups');
			$afd = querySelectPDO($begr_connPDO, 'SELECT af_id, afdeling,afdeling as naam FROM Afdeling');
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$active = 0;
				if($_POST['active']) $active = 1;

				$query = "INSERT INTO users (username, email, status, badge,afd, created_at, created_by) 
								VALUES ('" . $_POST['username'] . "', '" . $_POST['email'] . "', '" . $active . "', '" . $_POST['badgenr'] . "','" . $_POST['afd'] . "', GETDATE(), '" . getAppUserId() . "')";
                $resultset = $mis_connPDO->query($query);
				
				if($_POST['usergroup']){
					$lastId = getLastIdPDO($mis_connPDO, 'users', 'id');
					foreach($_POST['usergroup'] as $group_id){
						$groupquery = "INSERT INTO user_group (user_id, usergroup_id) VALUES ('" . $lastId . "', '" . $group_id . "')";			
						$resultset_group = $mis_connPDO->query($groupquery);
					}
				}

                if($_POST['userafdeling']){
                    $lastId = getLastIdPDO($mis_connPDO, 'users', 'id');
                    foreach($_POST['userafdeling'] as $af_id){
                        $groupquery = "INSERT INTO user_afdelingen (user_id, af_id) VALUES ('" . $lastId . "', '" . $af_id . "')";
                        $resultset_group = $mis_connPDO->query($groupquery);
                    }
                }
				
				header('Location: users.php?msg=saved');
			}
			
			require_once('tmpl/users_new.tpl.php');
			
		break;
		
		case 'edit':
			
			if(isset($_GET['id'])){
				$query = "SELECT * FROM users WHERE id='". $_GET['id'] . "'";
				$resultset = $mis_connPDO->query($query);
				$data = $resultset->fetch();
				
				$usergroups = querySelectPDO($mis_connPDO, 'SELECT * FROM usergroups');
				
				$selectedgroups = querySelectPDO($mis_connPDO, 'SELECT usergroup_id FROM user_group WHERE user_id = \'' . $_GET['id'] . '\'');
				$selectedgroupsArr = array();
				if(count($selectedgroups) == 1){
					$selectedgroupsArr[] = $selectedgroups['usergroup_id'];
				} else {
					foreach($selectedgroups as $group){ $selectedgroupsArr[] = $group['usergroup_id']; }
				}
				
				$afdelingen = querySelectPDO($begr_connPDO, 'SELECT af_id, afdeling,afdeling as naam FROM Afdeling order by afdeling');

                $selectedgroupsAF = querySelectPDO($mis_connPDO, 'SELECT af_id FROM user_afdelingen WHERE user_id = \'' . $_GET['id'] . '\'');
                $selectedgroupsArrAF = array();
                if(count($selectedgroupsAF) == 1){
                    $selectedgroupsArrAF[] = $selectedgroupsAF['af_id'];
                } else {
                    foreach($selectedgroupsAF as $groupAF){ $selectedgroupsArrAF[] = $groupAF['af_id']; }
                }
				
				
			}
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$active = 0;
				if($_POST['active']) $active = 1;
								
				$query = "	UPDATE users SET 
									username = '" . $_POST['username'] . "' ,
									email = '" . $_POST['email'] . "',
									status = '" . $active . "',
									badge = '" . $_POST['badgenr'] . "',
									afd = '" . $_POST['afd'] . "',
									updated_at = GETDATE(),
									updated_by = '" . getAppUserId() . "'
								WHERE id = '" .   $_GET['id'] . "'";
								
				$resultset = $mis_connPDO->query($query);
				
				$delquery = "DELETE FROM user_group WHERE user_id='". $_GET[id]. "'";
				$resultset = $mis_connPDO->query($delquery);

                $delqueryAF = "DELETE FROM user_afdelingen WHERE user_id='". $_GET[id]. "'";
                $resultsetAF = $mis_connPDO->query($delqueryAF);
				
				if($_POST['usergroup']){
					$lastId = $_GET['id'];
					foreach($_POST['usergroup'] as $group_id){
						$groupquery = "INSERT INTO user_group (user_id, usergroup_id) VALUES ('" . $lastId . "', '" . $group_id . "')";			
						$resultset = $mis_connPDO->query($groupquery);
					}
				}

                if($_POST['userafdeling']){
                    $lastId = $_GET['id'];
                    foreach($_POST['userafdeling'] as $af_id){
                        $groupquery = "INSERT INTO user_afdelingen (user_id, af_id) VALUES ('" . $lastId . "', '" . $af_id . "')";
                        $resultset_group = $mis_connPDO->query($groupquery);
                    }
                }
				
				header('Location: users.php?msg=updated');
				exit();
			}
			
			require_once('tmpl/users_edit.tpl.php');
			
		break;
		
		case 'delete':
			
			if(isset($_GET['id'])){
				$query0 = "DELETE FROM user_group WHERE user_id='". $_GET[id]. "'";
				$resultset = $mis_connPDO->query($query0);
				
				$query1 = "DELETE FROM users WHERE id='". $_GET[id]. "'";
				$resultset = $mis_connPDO->query($query1);
			}
			
			header('Location: users.php?msg=deleted');
			
		break;
		
	}
	
?>