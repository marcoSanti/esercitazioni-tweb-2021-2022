<?php

/*
 * parametri richiesti in payload:
 * -name
 * -surname
 * -email
 * */

function updateUserInformation(array $payload, PDO $conn){

    $nome = $payload["name"];
    $cognome = $payload["surname"];

    //UserType=0 normal user, 1 admin
    $query = "UPDATE users SET Name=:name, Surname=:surname WHERE email=:email";
    try{
        $stmt=$conn->prepare($query);
        $stmt->bindParam(":name", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":surname", $cognome, PDO::PARAM_STR);
        $stmt->bindParam(":email", $_SESSION["username"], PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(Array("Ok"=>"Updated"));
        exit();

    }catch (PDOException $e){
        http_response_code(500);
        echo json_encode(Array("Error"=>$e));
        exit();
    }




}