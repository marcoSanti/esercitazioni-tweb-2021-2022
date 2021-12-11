<?php

/*
 * parametri richiesti in payload:
 * nil
 *
 * */

function userIsLogged(array $payload, PDO $conn){
    if(isset($_SESSION["username"])){
        echo json_encode(Array("Status"=>"logged"));
    }else{
        echo json_encode(Array("Status"=>"not_logged"));
    }
}