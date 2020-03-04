<?php
require_once('php/conf/config.php');

/*echo '<pre>';
var_dump($_SESSION);
echo '</pre>';*/


if (!empty($_SESSION['mis']['user'])) {
    header('Location: main.php');
}

//logic goes here
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $error = array();

    $sthandler = $mis_connPDO->prepare('SELECT * FROM users WHERE username=?');
    $sthandler->execute(array($_POST['username']));
    if ($row = $sthandler->fetch()) {

        //check if it's a valid LDAP user
        $ldapconn = ldap_connect("");
        if (empty($ldapconn)) {
            $ldapconn = ldap_connect("") or die("Could not connect to LDAP server.");
        }

        $ldaprdn = $_POST['username'] . '@domain.com';
        $ldappass = $_POST['password'];

        if ($ldapconn && !empty($ldappass)) {

            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            if ($ldapbind) {
                $_SESSION['userName'] = $_POST['username'];
                $_SESSION['mis']['user']['id'] = $row['id'];
                $_SESSION['mis']['user']['username'] = $row['username'];
                $_SESSION['mis']['user']['email'] = $row['email'];
                $_SESSION['mis']['user']['badgenr'] = $row['badge'];
                $_SESSION['mis']['user']['afd'] = $row['afd'];

                $sthandlerRechten = $mis_connPDO->prepare("SELECT *  FROM user_group where user_id=? and usergroup_id='2074'");
                $sthandlerRechten->execute(array($row['id']));
                $rowRechten = $sthandlerRechten->fetch();
                if (empty($rowRechten)) {
                    $groupquery = "INSERT INTO user_group (user_id, usergroup_id) VALUES ('" . $row['id'] . "', '2074')";
                    $resultset_group = $mis_connPDO->query($groupquery);
                }


                header('location: main.php');
            } else {
                $error['msg'] = 'LDAP Login failed!';
            }
        }
        ldap_unbind($ldapconn);
    } else {

        //check if it's a valid LDAP user
        $ldapconn = ldap_connect("") or die("Could not connect to LDAP server.");

        $ldaprdn = $_POST['username'] . '@domain.com';
        $ldappass = $_POST['password'];

        if ($ldapconn && !empty($ldappass)) {

            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            if ($ldapbind) {
                $query = "INSERT INTO users (username, status, created_at, created_by)
								VALUES ('" . $_POST['username'] . "','1', GETDATE(), '0')";
                $resultset = $mis_connPDO->query($query);

                $lastId = getLastIdPDO($mis_connPDO, 'users', 'id');
                $groupquery = "INSERT INTO user_group (user_id, usergroup_id) VALUES ('" . $lastId . "', '2074')";
                $resultset_group = $mis_connPDO->query($groupquery);

                $error['msg'] = 'Uw account is aangemaakt! A.u.b. opnieuw inloggen om verder te gaan!';
            } else {
                $error['msg'] = 'LDAP Login failed!';
            }
        }
        ldap_unbind($ldapconn);
    }
}

require_once(TEMPLATE_PATH . 'login.tpl.php');
