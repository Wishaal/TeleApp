<?php
require_once('php/conf/config.php');

if (isset($_POST["ProfileUpdate"]) == 'true') {
	if(($_POST['badgeEmpty'] == 'true') && (!empty($_POST['Badge']))){
		$queryProfile = "UPDATE users SET 
					badge = '" . $_POST['Badge'] . "',
					updated_at = GETDATE(),
					updated_by = '" . getAppUserId() . "'
				WHERE id = '". $_SESSION['mis']['user']['id'] . "'";
	//print $queryProfile;				
	$resultsetProfile = $mis_connPDO->query($queryProfile);

	}elseif(($_POST['badgeEmpty'] == 'false') && (!empty($_POST['Badge']))){
	$queryProfile = "UPDATE werknemers SET 
					FirstName = '" . $_POST['FirstName'] . "',
					Name = '" . $_POST['LastName'] . "'
				WHERE Code = '" . $_POST['Badge'] . "'";
	//print $queryProfile;				
	$resultsetProfile = $mis_connPDO->query($queryProfile);

		$queryProfileUser = "UPDATE users SET 
					email = '" . $_POST['Email'] . "',
					updated_at = GETDATE(),
					updated_by = '" . getAppUserId() . "'
				WHERE id = '". $_SESSION['mis']['user']['id'] . "'";
	//print $queryProfile;				
	$resultsetProfileUser = $mis_connPDO->query($queryProfileUser);
	}
	$_SESSION['mis']['user']['badgenr'] = $_POST['Badge'];
} else {}

header('Location: ' . $_SERVER['HTTP_REFERER'].'?profileUpdate=true');
exit;
?>