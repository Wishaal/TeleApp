<?php
    $menuid = 1494;
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
			$dataquery = 'SELECT * FROM externe_gegevens';
			$dataresultset = $db->query($dataquery);
			$data = array();
			// Parse returned data, and displays them
			while($row = $dataresultset->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
		
			require_once('tmpl/externe.reserveringen.tpl.php');
			
		break;
		
		case 'new':
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$active = 0;
				if($_POST['active']) $active = 1;
				$query = "INSERT INTO externe_gegevens (name, description, created_at, created_by) 
								VALUES ('" . $_POST['name'] . "', '" . $_POST['description'] . "', GETDATE(), '" . getAppUserId() . "')";
				$dataresultset = $db->query($query);
				
				header('Location: externe.reserveringen.php?msg=saved');
			}
			
			require_once('tmpl/externe.reserveringen.new.tpl.php');
			
		break;
		
		case 'edit':
			
			if(isset($_GET['id'])){
				$query = "SELECT * FROM externe_gegevens WHERE id='". $_GET['id'] . "'";
				$resultset = $db->query($query);
				$data = $resultset->fetch();
				
			}
			
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$active = 0;
				if($_POST['active']) $active = 1;		
				$query = "	UPDATE externe_gegevens SET 
									name = '" . $_POST['name'] . "' ,
									description = '" . $_POST['description'] . "',
									updated_at = GETDATE(),
									updated_by = '" . getAppUserId() . "'
								WHERE id = '" .   $_GET['id'] . "'";
				$resultset = $db->query($query);
				
				header('Location: externe.reserveringen.php?msg=updated');
				exit();
			}
			
			require_once('tmpl/externe.reserveringen.edit.tpl.php');
			
		break;
		
		case 'delete':
			
			if(isset($_GET['id'])){

					$query = "DELETE FROM externe_gegevens WHERE id='". $_GET[id]. "'";
					$resultset = $db->query($query);

					header('Location: externe.reserveringen.php?msg=deleted');
					exit();

			}
			
		break;
		
	}