<?php
$menuid = 65;

require_once('../../php/conf/config.php');
require_once('../../inc_topnav.php');
require_once('../../inc_sidebar.php');
require_once('php/config.php');

//start fresh
unset($_SESSION['spec']['data']);
unset($_SESSION['spec']['header']);

$users = querySelectPDO($mis_connPDO, 'SELECT * FROM users order by username');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nummer = $_POST['nummer'];
    $begindatum = $_POST['begindatum'];
    $einddatum = $_POST['einddatum'];
    $aansluitnummer = trim($_POST['aansluitnummer']);
    $username = trim($_POST['username']);


    $data = array();
    $header = array();

    $aansl_q = '';
    if (!empty($aansluitnummer)) {
        $aansl_q = ' AND details LIKE \'%' . $aansluitnummer . '%\' ';
    }

    $user_q = '';
    if (!empty($username)) {
        $user_q = ' AND l.user_id = ' . $username . ' ';
    }

    $query = 'SELECT 
					l.*, u.username 
				  FROM [dbo].[log] AS l JOIN
				  [dbo].[users] AS u ON l.user_id = u.id 
				  WHERE l.created_at BETWEEN \'' . $begindatum . ' 00:00:00.000\' AND \'' . $einddatum . ' 23:59:59.000\' ' . $aansl_q . ' ' . $user_q . ' ORDER BY created_at ASC';


    $data = querySelectPDO($mis_connPDO, $query);


    $header['begindatum'] = $begindatum;
    $header['einddatum'] = $einddatum;
    $header['aansluitnummer'] = $aansluitnummer;

    $_SESSION['spec']['data'] = $data;
    $_SESSION['spec']['header'] = $header;
}

require_once('tmpl/log.tpl.php');
?>