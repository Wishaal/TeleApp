<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

date_default_timezone_set('America/Paramaribo');

$currentDateTime = date('Y-m-d h:i:s a', time());

//========================================define constants=============================
define('APP_TITLE', 'ICT Facilities ');
define('PATH', realpath(dirname(__FILE__)) . '/../../');
define('TEMPLATE_PATH', PATH . 'tmpl/');
define('ASSETS_PATH', PATH . 'assets/');
define('PHP_PATH', PATH . 'php/');


define('CONTEXT_PATH', 'telesur_mis/');
define('BASE_HREF', 'http://' . $_SERVER['HTTP_HOST'] . '/' . CONTEXT_PATH);
define('APP_SECTION', NULL);

define('LIFETIME', (4 * 60 * 60)); //hours * minutes * seconds

if (empty($_SESSION['mis']['user']) && !strstr($_SERVER['SCRIPT_NAME'], 'index.php')) {
    header('Location: ' . BASE_HREF . 'index.php');
} else {

    if (isset($_SESSION['timeout']) && ($_SESSION['timeout'] + LIFETIME) < time()) {
        header('Location: ' . BASE_HREF . 'logout.php');
    }
}

$_SESSION['timeout'] = time();


//========================================connection=============================

//mis database connection
try {
$mis_connPDO = new PDO("sqlsrv:Server=; Database=;", "", "");
$mis_connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {

    $msg = $e->getMessage();
}
//vp database connection
try {
$vp_connPDO = new PDO("sqlsrv:Server=; Database=;", "", "");
$vp_connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {

    $msg = $e->getMessage();
}
//aob database connection
$aob_connPDO = new PDO("sqlsrv:Server=; Database=;", "", "");
$aob_connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//begr database connection
$begr_connPDO = new PDO("sqlsrv:Server=; Database=;", null, null);
$begr_connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//mis database connection old way
$mis_servername = '';
$mis_conn_info = array('database' => '', 'ReturnDatesAsStrings' => true);
$mis_conn = sqlsrv_connect($mis_servername, $mis_conn_info) or die('Could not connect to the server!');
define('MIS_CONN', $mis_conn);

//aob database connection to check native menuitems old way
$aob_servername = '';
$aob_conn_info = array('database' => '', 'ReturnDatesAsStrings' => true);
$aob_conn = sqlsrv_connect($aob_servername, $aob_conn_info) or die('Could not connect to the server!');
define('AOB_CONN', $aob_conn);

//aob database connection to check native menuitems old way
$begr_servername = '';
$begr_conn_info = array('database' => 'ez', 'ReturnDatesAsStrings' => true);
$begr_conn = sqlsrv_connect($begr_servername, $begr_conn_info) or die('Could not connect to the server!');
define('BEGR_CONN', $begr_conn);

$begr_connPDO = new PDO("sqlsrv:Server=; Database=;", "", "");
$begr_connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function getAppUserName()
{
    return $_SESSION['mis']['user']['username'];
}

function getAppUserId()
{
    return $_SESSION['mis']['user']['id'];
}

function getAppUserBadgenr()
{
    return $_SESSION['mis']['user']['badgenr'];
}

function getAppUserAfdeling()
{
    return $_SESSION['mis']['user']['afd'];
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function formatBytes_New($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'k', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

function showError()
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

//creates dropdown option with years
function yearDropdown($startYear, $endYear, $id = "year")
{
    //start the select tag
    echo "<select class=\"selectpicker form-control\" id=" . $id . " name=" . $id . ">n";

    //echo each year as an option
    for ($i = $startYear; $i <= $endYear; $i++) {
        echo "<option value='" . $i . "'";
        if (empty($_POST['year'])) {
            $year = date('Y');
        } else {
            $year = $_POST['year'];
        }
        if ($year == $i) {
            echo ' selected="selected"';
        }
        echo ">" . $i . "</option>n";
    }

    //close the select tag
    echo "</select>";
}

function getUsergroups($userid)
{
    global $mis_connPDO;
    $data = querySelectPDO($mis_connPDO, "select distinct(name) from user_group,usergroups 
                        where user_group.usergroup_id = usergroups.id and user_group.user_id=" . $userid);
    $role = array();
    foreach ($data as $r) {
        $role[] = $r['name'];
    }

    $two = implode(',', $role);

    return $two;
}

//========================================query_functions with PDO=============================

function getUsergroupByUserid($userid)
{
    $query = 'SELECT usergroup_id FROM user_group WHERE wk_ID = ' . $userid;
    $ids = array();
    $res = querySelectlist($query);
    foreach ($res as $r) {
        $ids[] = $r['usergroup_id'];
    }

    return $ids;
}

//encapsulated function for selecting
function querySelectPDO($db, $selectquery)
{
    // Define and perform the SQL SELECT query
    $query = $selectquery;
    $result = $db->query($query);
    $data = array();
    // Parse returned data, and displays them
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    if (count($data) == 1) {
        return $data[0];
    } else {
        return $data;
    }
}

function querySelectlistPDO($db, $selectquery)
{
    // Define and perform the SQL SELECT query
    $query = $selectquery;
    $result = $db->query($query);
    $data = array();
    // Parse returned data, and displays them
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    return $data;

}

function recordLog($userid, $app, $details)
{
    $query = "INSERT INTO log (user_id, app, details, created_at) VALUES ('" . $userid . "', '" . $app . "', '" . $details . "', GETDATE())";
    $resultset = sqlsrv_query(MIS_CONN, $query) or die('A error occured: ' . $query);
    sqlsrv_free_stmt($resultset);
}

function recordLogPDO($mis_connPDO, $userid, $app, $details)
{
    $stmt = $mis_connPDO->prepare("INSERT INTO log (user_id, app, details, created_at) VALUES (:userid, :app, :details, GETDATE())");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':app', $app);
    $stmt->bindParam(':details', $details);
    $stmt->execute();
}

function getProfileInfo($db, $info, $id)
{
    $text = str_replace('W', '', $id);
    $check = $db->prepare("SELECT * FROM NAVWerknemers where werk_persnr='$text'");
    $check->execute();
    $check = $check->fetch();

    return $check[$info];
}

function getProfileInfoUsers($db, $info, $id)
{
    $text = str_replace('W', '', $id);
    $check = $db->prepare("SELECT * FROM users where badge='$text'");
    $check->execute();
    $check = $check->fetch();

    return $check[$info];
}

function getLastIdPDO($db, $tablename, $index)
{
    $check = $db->prepare("SELECT MAX(" . $index . ") AS id FROM " . $tablename);
    $check->execute();
    $check = $check->fetch();
    return $check['id'];
}

function getFullAppnamePDO($mis_conn, $id)
{

    $a = querySelectPDO($mis_conn, 'SELECT y.title + \' > \' + x.title + \' > \' + a.title AS title
									FROM menuitem AS a
									JOIN menuitem AS x ON a.parent = x.id 
									JOIN menuitem AS y ON x.parent = y.id 
									WHERE a.id = \'' . $id . '\'');

    return $a['title'];
}

//get second menu level for log purpose
function getSecondLevelAppnamePDO($mis_connPDO, $id)
{

    $a = querySelectPDO($mis_connPDO, 'SELECT x.title + \' > \' + a.title AS title
									FROM menuitem AS a
									JOIN menuitem AS x ON a.parent = x.id 
									WHERE a.id = \'' . $id . '\'');

    return $a['title'];
}

/**
 *    Checks if the logged on user has a certain permisson
 *  $menuid: the id of the menu in question
 *  $permissiontype: SELECT, INSERT, UPDATE, DELETE, OTHER (note: all in CAPS)
 *  returns true if user has permission else false
 *  example: hasPermission(101, 'SELECT');
 **/
function hasPermissionPDO($mis_connPDO, $menuid, $permissiontype)
{
    // Define and perform the SQL SELECT query
    $sql = 'SELECT permission_' . strtolower($permissiontype) . ' AS permission FROM permission WHERE menunr = ' . $menuid . ' AND usergroup_id IN (SELECT usergroup_id FROM user_group WHERE user_id = ' . getAppUserId() . ')';
    $result = $mis_connPDO->query($sql);
    $data = array();
    // Parse returned data, and displays them
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    $permission = 0;
    foreach ($data as $i) {
        if ($i['permission'] == 1) {
            $permission = 1;
        }
    }

    return ($permission == 1 ? true : false);
}

//code to prevent sql injections
function anti_injection($sql)
{
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $sql);
    $sql = trim($sql);
    $sql = strip_tags($sql);
    $sql = addslashes($sql);
    return $sql;
}

//get username in teleapp
function getUsernamePDO($mis_connPDO, $id)
{
    $check = $mis_connPDO->prepare("SELECT username FROM users where id='" . $id . "'");
    $check->execute();
    $check = $check->fetch();

    return $check['username'];
}

function getUserIdByBadgenr($mis_connPDO, $id)
{
    global $mis_connPDO;
    $query="SELECT id FROM users where badge='" . $id . "'";
    $check = $mis_connPDO->prepare($query);
    $check->execute();

    $check = $check->fetch();

    return $check['id'];
}

//get email in teleapp
function getEmailPDO($mis_connPDO, $id)
{
    global $mis_connPDO;
    $check = $mis_connPDO->prepare("SELECT email FROM users where id=" . $id);
    $check->execute();
    $check = $check->fetch();

    return $check['email'];
}

function generateCode()
{

    $unique = FALSE;
    $length = 7;
    $chrDb = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    while (!$unique) {

        $str = '';
        for ($count = 0; $count < $length; $count++) {

            $chr = $chrDb[rand(0, count($chrDb) - 1)];

            if (rand(0, 1) == 0) {
                $chr = strtolower($chr);
            }
            if (3 == $count) {
                $str .= '-';
            }
            $str .= $chr;
        }

        /* check if unique */
        //$existingCode = UNIQUE CHECK GOES HERE
        //if (!$existingCode){
        //    $unique = TRUE;
        //}
    }
    return $str;
}

function get_real_up_address()
{
    if (isset($_SERVER)) {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];
        return $_SERVER["REMOTE_ADDR"];
    }
    if (getenv("HTTP_X_FORWARDED_FOR"))
        return getenv("HTTP_X_FORWARDED_FOR");
    if (getenv("HTTP_CLIENT_IP"))
        return getenv("HTTP_CLIENT_IP");
    if (getenv("REMOTE_ADDR"))
        return getenv("REMOTE_ADDR");
    return "UNKNOWN";
}

//========================================query_functions old way=============================

//encapsulated function for selecting
function querySelect($connection, $selectquery)
{
    $query = $selectquery;
    $resultset = sqlsrv_query($connection, $query);
    $data = array();
    while ($row = sqlsrv_fetch_array($resultset, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }
    sqlsrv_free_stmt($resultset);
    if (count($data) == 1) {
        return $data[0];
    } else {
        return $data;
    }
}

function querySelectlist($connection, $selectquery)
{
    $query = $selectquery;
    $resultset = sqlsrv_query($connection, $query);
    $data = array();
    while ($row = sqlsrv_fetch_array($resultset, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }
    sqlsrv_free_stmt($resultset);
    return $data;

}

function getLastId($connection, $tablename, $index)
{
    $query = "SELECT MAX(" . $index . ") AS id FROM " . $tablename;
    $resultset = sqlsrv_query($connection, $query) or die('A error occured: ' . $query);
    $row = sqlsrv_fetch_array($resultset);
    sqlsrv_free_stmt($resultset);
    return $row['id'];
}

function getKstnplOmschrijving($connection, $tablename, $index)
{
    $query = "SELECT oms25_0 FROM " . $tablename . " where reknr=" . $index;
    $resultset = sqlsrv_query($connection, $query) or die('A error occured: ' . $query);
    $row = sqlsrv_fetch_array($resultset);
    sqlsrv_free_stmt($resultset);
    return $row['oms25_0'];
}

function getKstnpl($connection, $tablename, $index)
{
    $query = "SELECT kostenpl FROM " . $tablename . " where afdeling='" . $index."'";
    $resultset = sqlsrv_query($connection, $query) or die('A error occured: ' . $query);
    $row = sqlsrv_fetch_array($resultset);
    sqlsrv_free_stmt($resultset);
    return $row['kostenpl'];
}


function getStrategieOmschrijving($connection, $tablename, $index)
{
    if ($index == NULL) {
        $var = '0';
    } else {
        $var = $index;
    }
    $query = "SELECT str_omschrijving FROM " . $tablename . " where str_id=" . $var;
    $resultset = sqlsrv_query($connection, $query) or die('A error occured: ' . $query);
    $row = sqlsrv_fetch_array($resultset);
    sqlsrv_free_stmt($resultset);
    return $row['str_omschrijving'];
}


/**
 *    Checks if the logged on user has a certain permisson
 *  $menuid: the id of the menu in question
 *  $permissiontype: SELECT, INSERT, UPDATE, DELETE, OTHER (note: all in CAPS)
 *  returns true if user has permission else false
 *  example: hasPermission(101, 'SELECT');
 **/
function hasPermission($menuid, $permissiontype)
{

    $query = 'SELECT permission_' . strtolower($permissiontype) . ' AS permission FROM permission WHERE menunr = ' . $menuid . ' AND usergroup_id IN (SELECT usergroup_id FROM user_group WHERE user_id = ' . getAppUserId() . ')';

    $resultset = sqlsrv_query(MIS_CONN, $query);
    $data = array();
    while ($row = sqlsrv_fetch_array($resultset, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }
    sqlsrv_free_stmt($resultset);

    $permission = 0;
    foreach ($data as $i) {
        if ($i['permission'] == 1) {
            $permission = 1;
        }
    }

    return ($permission == 1 ? true : false);
}

//simple function to draw table
function displayTable($db, $query, $class, $id)
{
    $rs = $db->query($query);
    for ($i = 0; $i < $rs->columnCount(); $i++) {
        $col = $rs->getColumnMeta($i);
        $columns[] = $col['name'];
    }

    $result = $db->query($query);
    $data = array();
    // Parse returned data, and displays them
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    $table = '';

    $table .= '<table id="' . $id . '" class="' . $class . '"> 
								<thead><tr>';
    $count = 0;
    foreach ($columns as $r) {
        $count++;
        $table .= '<th>' . $r . '</th>';
    }

    $table .= '</tr></thead><tbody>';
    $countx = 0;
    foreach ($data as $r) {
        $countx++;
        $table .= '<tr>';
        $countxx = 0;
        foreach ($columns as $rr) {
            $countxx++;
            $table .= '<td>' . $r[$rr] . '</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</tbody></table>';
    return $table;
}

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];

    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

function getNameLDAP($username)
{

    //check if it's a valid LDAP user
    $ldapconn = ldap_connect("") or die("Could not connect to LDAP server.");

    $ldaprdn = '';
    $ldappass = '';

    if ($ldapconn && !empty($ldappass)) {

        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

        $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

        if ($ldapbind) {
            //------------------------------------------------------------------------------
            // Get a list of all Active Directory users.
            //------------------------------------------------------------------------------
            $ldap_base_dn = 'DC=telesur,DC=COM';
            $search_filter = "(|(samaccountname=$username))";
            //$justthese = array('ou', 'sn', 'givenname', 'mail');
            $result = ldap_search($ldapconn, $ldap_base_dn, $search_filter);
            if (FALSE !== $result) {
                $entries = ldap_get_entries($ldapconn, $result);
                if ($entries['count'] > 0) {
                    $surname = $entries[0]['sn'][0];
                    $givenname = $entries[0]['givenname'][0];
                }
            }
        }
    }


    return $surname . ' ' . $givenname;
}

function getEmailLDAP($username)
{

    //check if it's a valid LDAP user
    $ldapconn = ldap_connect("") or die("Could not connect to LDAP server.");

    $ldaprdn = 'com';
    $ldappass = '';

    if ($ldapconn && !empty($ldappass)) {

        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

        $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

        if ($ldapbind) {
            //------------------------------------------------------------------------------
            // Get a list of all Active Directory users.
            //------------------------------------------------------------------------------
            $ldap_base_dn = 'DC=telesur,DC=COM';
            $search_filter = "(|(samaccountname=$username))";
            //$justthese = array('ou', 'sn', 'givenname', 'mail');
            $result = ldap_search($ldapconn, $ldap_base_dn, $search_filter);
            if (FALSE !== $result) {
                $entries = ldap_get_entries($ldapconn, $result);
                if ($entries['count'] > 0) {
                    $mail = $entries[0]['mail'][0];
                }
            }
        }
    }


    return $mail;
}

?>