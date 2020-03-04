<?php

require_once('../../php/conf/config.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('php/config.php');

$error = array();
$status = array();


$begin = getDatum($_POST['daterange'],'s');
$eind = getDatum($_POST['daterange'],'e');

//stap 1 check aantal goedegkeurde registraties
$aantalGoedGekeurdeRegistratie = aantalGoedekeurdeRegistratie($db,$begin,$_SESSION['mis']['user']['badgenr']);
$checkIfSameDateRegistration = checkIfSameDateRegistration($db,$begin,$eind,$_SESSION['mis']['user']['badgenr']);
$checkIfRegistrationExist = checkIfRegistrationExist($db,$_POST['w_id'],$begin,$eind);
$checkWachtlijstStatus = checkWachtlijstStatus($db,$_POST['w_id'],$begin,$eind);
$wachtlijst = $_POST['wachtlijst'];

if($aantalGoedGekeurdeRegistratie['aantal'] <= 1){
    if(empty($checkIfSameDateRegistration)){
        if(empty($checkIfRegistrationExist) || $wachtlijst == 1){
             $final = finalInsert($db,$_POST['w_id'],$_POST['daterange'],$_SESSION['mis']['user']['badgenr']);

             if(in_array('ja', $final, true)){
                 $status[] = "Uw aanvraag is doorgevoerd!";
             }else{
                 $error[] = "Aanvraag bestaat al!";
             }
        }else{
            if(empty($checkWachtlijstStatus)){
                $error[] = "Iemand is u voor, wilt u op de wachtlijst staan?";
                $wachtlijst = 2;
            }else{
                $error[] = "De wachtlijst is ook al vol, gelieve een andere datum gekiezen.";
            }

        }
    }else {
        $error[] = "U mag maar een woning selecteren per periode.";
    }

}else{
    $error[]="U heeft al twee keren gereserveerd voor dit jaar.";
}

echo json_encode(array("error" => $error,"status" => $status,"wachtlijst" => $wachtlijst));


