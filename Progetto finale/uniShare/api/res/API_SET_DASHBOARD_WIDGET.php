<?php
/*
 * parametri richiesti in payload:
 * -position
 * -widget
 * 
 * Questa pi permette di salvare una modifica all'aspetto della dashboard di un utente
 * */

function setDashboardWidget(array $payload, PDO $conn){

    loginCheck();


    if($payload["position"]<1 || $payload["position"]>4){
        http_response_code(500);
        echo json_encode(Array("Error"=>"Unknown position"));
        exit();
    }

    /*
     * non uso $stmt->bindValue() in quanto viene generato un errore di type mismatch dal server sql
     * */
    $obj = "obj" . filter_var($payload["position"], FILTER_SANITIZE_NUMBER_INT);

    try{
        $stmt = $conn->prepare("UPDATE dashboard SET $obj = :widget WHERE user = :user;");
        $stmt->bindValue(":user", $_SESSION["username"], PDO::PARAM_STR);
        $stmt->bindValue(":widget", $payload["widget"], PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(Array("Ok"=>"Updated"));
    }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}
    
}