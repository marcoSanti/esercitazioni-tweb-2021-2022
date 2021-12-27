<?php

/*
 * parametri richiesti in payload:
 * -name
 * -surname
 * -email
 * -password
 * */

function signup(array $payload,PDO $conn){

    //UserType=0 normal user, 1 admin
    try{
        $password = hash("sha512", $payload["password"]);
        $stmt=$conn->prepare( "INSERT INTO `Users` ( `Name`, `Surname`, `email`, `password`, `UserType`) VALUES ( :name, :surname, :mail, :password, '0');");
        $stmt->bindParam(":name", $payload["name"], PDO::PARAM_STR);
        $stmt->bindParam(":surname", $payload["surname"], PDO::PARAM_STR);
        $stmt->bindParam(":mail", $payload["email"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $password , PDO::PARAM_STR);
        $stmt->execute();

        //automatically logs in the user after registration
        session_destroy();
        session_start();
        $_SESSION["username"] = filter_var($payload["email"], FILTER_VALIDATE_EMAIL);

  
        $stmt1 = $conn->prepare("INSERT INTO dashboard (obj1, obj2, obj3, obj4, user) VALUES(0,1,2,3,:mail);");
        $stmt1->bindParam(":mail", $payload["email"], PDO::PARAM_STR);
        $stmt1->execute();
        jsonReturnOkEcho();
    }catch(PDOException $e){jsonReturnEcho(500, "Error", $e);}



}