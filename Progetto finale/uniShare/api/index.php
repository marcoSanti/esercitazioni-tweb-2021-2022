<?php

/*
 * Ogni richiesta di api deve essere fatta inviando un oggetto json con:
 * -api: l'api richiesta
 * -payload: un array json contenente tutto il contenuto necessario a soddisfare la richiesta
 * */
header("Content-Type: text/javascript");

if(!@require_once "config.php"){
    http_response_code(500);
    echo json_encode(Array("Error" => "Unable to include config file!"));
    exit();
}

if(!@require_once "apiList.php"){
    http_response_code(500);
    echo json_encode(Array("Error" => "Unable to load api list!"));
    exit();
}

if (!isset($_SESSION)) { session_start(); }

/*
 * impostando il codice in questo modo mi lascio la possibilità
 * di estendere le funzionalità del mio backend in modo semplice e pulito*/
switch($_SERVER["REQUEST_METHOD"]){
    case 'POST':
        $input = json_decode(file_get_contents("php://input" ), true); //obtain input without using $_POST aray
        $api_request = $input["api"];
        $payload = $input["payload"];

        if(!array_key_exists($api_request, $available_apis)){
            http_response_code(400);
            json_encode(Array("Error"=>"No api found!"));
            exit();
        }

        if(!@require_once $available_apis[$api_request]["FILE"]){
            http_response_code(500);
            echo json_encode(Array("Error"=>"Unable to load api!"));
            exit();
        }

        $available_apis[$api_request]["FUNC"]($payload, $conn);


        break;

    default:
        http_response_code(400);
        echo json_encode(Array("Error"=>"Unhandled HTTP method: " . $_SERVER["REQUEST_METHOD"]));
        exit();
}



