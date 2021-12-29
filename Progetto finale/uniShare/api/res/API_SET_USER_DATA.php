<?php

/*
 * parametri richiesti in payload:
 * -name
 * -surname
 * -email
 * 
 * Questa api permette di aggiornare le informazioni dell'utente
 * */

function updateUserInformation(array $payload, PDO $conn){

    loginCheck();

    //UserType=0 normal user, 1 admin
    $query = "UPDATE users SET Name=:name, Surname=:surname WHERE email=:email";
    try{
        $stmt=$conn->prepare($query);
        $stmt->bindParam(":name", $payload["name"], PDO::PARAM_STR);
        $stmt->bindParam(":surname", $payload["surname"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $_SESSION["username"], PDO::PARAM_STR);
        $stmt->execute();

        jsonReturnOkEcho();

    }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}




}