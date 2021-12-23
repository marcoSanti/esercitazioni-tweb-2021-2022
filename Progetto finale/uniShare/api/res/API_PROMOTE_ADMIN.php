<?php


/*
 * parametri richiesti in payload:
 * username -> email user da mettere admin
 *
 * Questa api ritorna gli utenti del sito
 * */


function promote(array $payload, PDO $conn)
{

    if (!isset($_SESSION["username"])) {
        echo json_encode(array("Error" => "User not logged in"));
        exit();
    } else {

        try{
            //check user is admin
            $stmtCheckAdmin = $conn->prepare("SELECT * from users where email = :mail");
            $stmtCheckAdmin->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
            $stmtCheckAdmin->execute();
            if($stmtCheckAdmin->rowCount()!=1){
                http_response_code(403);
                echo json_encode(Array("Error"=>"User has no rights for query"));
                exit();
            }

            $stmtPromoteUser = $conn->prepare("UPDATE users SET UserType = 1 where email = :mail");
            $stmtPromoteUser->bindValue(":mail", $payload["username"], PDO::PARAM_STR);
            $stmtPromoteUser->execute();

            echo json_encode(Array("Ok"=>"Done"));
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(array("Error" => $e));
            exit();
        }

    }
}
