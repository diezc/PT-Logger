<?php

/**
 * Este programa recive por GET un ID de dispositivo, recoge su token y prepara las variables para agregarlas a la BBDD.
 * 
 * @project PT_Logger
 * @file    /updateRequest.php
 * @authors Cesar Martin (@diezc)
 * @date    04/04/2017
 * @brief   Este programa recive por GET un ID de dispositivo, recoge su token y prepara las variables para agregarlas a la BBDD.
 * @version 6
 */

error_reporting(0); //E_ALL - 0 -> Flag to E_ALL for full debug-error output

require './phpParticle.class.php';
require './phpParticle.config.php';
require './ptloggerMngr.class.php';

$ptloggerMngr = new ptloggerMngr($bbdd_user, $bbdd_password, $bbdd_server, $bbdd);
$particle = new phpParticle();
$particle->setDebug(false); //Flag to true for debug output
$particle->setDebugType("HTML");

$particle->debug("DEBUG: All objects created, debug settings set");

if (isset($_GET['device_id']) && isset($_GET['value_type'])) { //Check arrival of device_id 
    $particle->debug("DEBUG: Setting variables");
    $deviceID = $_GET['device_id'];
    $value_type = $_GET['value_type'];
    $particle->debug("DEBUG: Device and Value type: $deviceID $value_type");

    if ($ptloggerMngr->set_bbddConection()) {
        $particle->debug("DEBUG: BBDD Connection successful");
    } else {
        $particle->debug("DEBUG: BBDD Connection failed");
    }

    if ($ptloggerMngr->get_devIDStatus($deviceID) === 1) {
        $particle->debug("DEBUG: Device ID exists </br>");
        $accessToken = $ptloggerMngr->get_token($deviceID);
        $particle->debug("DEBUG: Token obtained</br>");
        $particle->setAccessToken($accessToken);
        $particle->debug("DEBUG: Token set </br>");


        if ($particle->getVariable($deviceID, $ptloggerMngr->get_variableName($value_type)) == true) {
            $particle->debug("DEBUG: variable obtained </br>");
            $particle->debug("Success");
            $reply = $particle->getResult();
            $particle->debug_r($particle->getResult());
            $ptloggerMngr->set_dataValues($value_type, $reply['result'], $deviceID);

        } else {
            $particle->debug("DEBUG: Error obtaining variable </br>");
            $particle->debug("Error: " . $particle->getError());
            $particle->debug("Error Source" . $particle->getErrorSource());
        }
    } else {
        $particle->debug("BAD ID");
    }
} else {

    $particle->debug("BAD GET </br>");
}

$ptloggerMngr->close_bbddConection();
?>
