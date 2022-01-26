<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna la dashboard dell'utente
 * */

function getUserDashboard(array $payload, PDO $conn){

    loginCheck();
        $sql = "SELECT obj1, obj2, obj3, obj4 FROM dashboard WHERE user = :mail";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);
        }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}
    
}