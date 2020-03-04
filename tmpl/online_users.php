<?php
$session=session_id();
$time=time();
$time_check=$time-1800; //SET TIME 10 Minute

$stmt = $mis_connPDO->query("SELECT * FROM online_users WHERE session='$session'");
$row_count = $stmt->rowCount();
$ua=getBrowser();
$yourbrowser= " | browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];
if ($row_count == '0')
{
  $dataquery = "INSERT INTO online_users
  (username, session, time,ip_address, refurl,activity,datum) VALUES ('" . $_SESSION['mis']['user']['username'] . "', '" . $session . "', '" . $time. "', '".$_SERVER['REMOTE_ADDR']."', '".  $_SERVER['HTTP_REFERER']."', '".$_SERVER['SERVER_NAME'].' | '.$_SERVER['PHP_SELF']."',GETDATE())";	
  $result = $mis_connPDO->query($dataquery);
  $dataquery_log = "INSERT INTO log_users
  (username, session, time,ip_address,refurl, activity,datum) VALUES ('" . $_SESSION['mis']['user']['username'] . "', '" . $session . "', '" . $time. "', '".$_SERVER['REMOTE_ADDR']."', '".  $_SERVER['HTTP_REFERER']."', '".$_SERVER['SERVER_NAME'].' | '.$_SERVER['PHP_SELF'].' | '. $yourbrowser ."',GETDATE())";
  $result_log = $mis_connPDO->query($dataquery_log);
  }
else
{
  $dataquery_update = "UPDATE online_users SET username='" . $_SESSION['mis']['user']['username'] . "', time='$time', activity='".$_SERVER['SERVER_NAME'].' | '.$_SERVER['PHP_SELF'].' | '. $yourbrowser ."', datum=GETDATE() WHERE session = '$session'";				
  $result_update = $mis_connPDO->query($dataquery_update);
}
$dataquery_delete = "DELETE FROM online_users WHERE time<$time_check";								
$result_delete = $mis_connPDO->query($dataquery_delete);
?>