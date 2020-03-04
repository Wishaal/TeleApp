<?php
	
	require_once('php/conf/config.php');
	$username = $_SESSION['mis']['user']['username'];
	$afd =  substr($username,4,3);
	if ($afd == 'ez')
	{
	$query = "	UPDATE users SET 
									afd = 'P&C'
								WHERE username = '" .   $_SESSION['mis']['user']['username'] . "'";
								
				sqlsrv_query(MIS_CONN, $query) or die('A error occured: ' . sqlsrv_error());
	}
	//$query_d = "DELETE FROM online_users WHERE username = '" .   $_SESSION['mis']['user']['username'] . "'";								
	//sqlsrv_query(MIS_CONN, $query_d) or die('A error occured: ' . $query_d);
	unset($_SESSION['mis']);
	unset($_SESSION['user']);
	unset($_SESSION['username']);
	unset($_SESSION['userName']);
	unset($_SESSION['timeout']);
	unset($_SESSION['spec']['data']);
	session_destroy();
	 
	header('location: ' . BASE_HREF . 'index.php');
	exit();
?>