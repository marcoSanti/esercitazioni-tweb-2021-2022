<?php
/*
 * parametri richiesti in payload:
 * productId
 *
 * Questa api ritorna le università a db
 * */

function buy(array $payload, PDO $conn){

        loginCheck();
        $sql = "insert into acquisto (user, appunto) VALUES (:username, :appunto);";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":appunto", $payload["productId"], PDO::PARAM_STR);
            $stmt->bindValue(":username",$_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();

            jsonReturnOkEcho();

        }catch (PDOException $e){ jsonReturnEcho(500, "Error", $e); }
    }
