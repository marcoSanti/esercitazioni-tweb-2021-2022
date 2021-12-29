<?php

/*
 * Ogni richiesta di api deve essere fatta inviando un oggetto json con:
 * -api: l'api richiesta
 * -payload: un array json contenente tutto il contenuto necessario a soddisfare la richiesta
 * */

header("Content-Type: text/javascript");

if(!@require_once "utils.php"){
    http_response_code(500);
    echo json_encode(Array("Error" => "Unable to load utilities!"));
    exit();
}

if(!@require_once "config.php"){
    jsonReturnEcho(500, "Error",  "Unable to include config file!");
}

if(!@require_once "apiList.php"){
    jsonReturnEcho(500, "Error",  "Unable to load api list!");
}


if (!isset($_SESSION)) { session_start(); }

/*
 * impostando il codice in questo modo mi lascio la possibilità
 * di estendere le funzionalità del mio backend in modo semplice e pulito
 * uso solo il metodo post perchè in questo modo non traccio mai i parametri delle richieste nei file di log!
 * */
switch($_SERVER["REQUEST_METHOD"]){
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true); //obtain input without using $_POST aray

        $api_request = $input["api"];
        $payload = $input["payload"];


        if(!array_key_exists($api_request, $available_apis)){
            jsonReturnEcho(400, "Error",  "No api found with current request");
        }

        if(!@require_once $available_apis[$api_request]["FILE"]){
            jsonReturnEcho(500, "Error",  "Unable to start api execution");
        }

        $available_apis[$api_request]["FUNC"]($payload, $conn);

        break;

    default:
        jsonReturnEcho(400, "Error", "Unhandled HTTP method: " . $_SERVER["REQUEST_METHOD"]);
}



