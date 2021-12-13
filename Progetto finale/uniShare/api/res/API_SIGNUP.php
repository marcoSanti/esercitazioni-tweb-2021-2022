<?php

/*
 * parametri richiesti in payload:
 * -name
 * -surname
 * -email
 * -password
 * */

function signup(array $payload,PDO $conn){

    $nome = $payload["name"];
    $cognome = $payload["surname"];
    $email = $payload["email"];
    $password = hash("sha512", $payload["password"]);

    //UserType=0 normal user, 1 admin
    $query = "INSERT INTO `Users` ( `Name`, `Surname`, `email`, `password`, `UserType`) VALUES ( :name, :surname, :mail, :password, '0');";
    try{
        $stmt=$conn->prepare($query);
        $stmt->bindParam(":name", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":surname", $cognome, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        //automatically logs in the user after registration
        session_destroy();
        session_start();
        $_SESSION["username"] = filter_var($email, FILTER_VALIDATE_EMAIL);

    }catch (PDOException $e){
        http_response_code(500);
        echo json_encode(Array("Error"=>$e));
        exit();
    }

    $query = "INSERT INTO dashboard (obj1, obj2, obj3, obj4, user) VALUES(0,1,2,3,:mail);";
    try {
        $stmt1 = $conn->prepare($query);
        $stmt1->bindParam(":mail", $email, PDO::PARAM_STR);
        $stmt1->execute();
        echo json_encode(Array("Ok"=>"Inserted"));
    }catch(PDOException $e){
        http_response_code(500);
        echo json_encode(Array("Error"=>$e));
        exit();
    }



}