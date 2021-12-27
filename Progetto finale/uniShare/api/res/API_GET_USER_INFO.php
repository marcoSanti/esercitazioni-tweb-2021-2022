<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna le informazioni dell'utente (nome, cognome ed email)
 * */

function getUserInfo(array $payload, PDO $conn){

    loginCheck();
        try{
            $stmt = $conn->prepare("SELECT Name, Surname, email FROM Users WHERE email = :mail");
            $stmt->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);
        }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}
    }
