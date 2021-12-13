<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna le informazioni dell'utente (nome, cognome ed email)
 * */

function getUserInfo(array $payload, PDO $conn){

    if(!isset($_SESSION["username"])){
        echo json_encode(Array("Error"=>"User not logged in"));
        exit();
    }else{
        $sql = "SELECT Name, Surname, email FROM Users WHERE email = :mail";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }
    }
}