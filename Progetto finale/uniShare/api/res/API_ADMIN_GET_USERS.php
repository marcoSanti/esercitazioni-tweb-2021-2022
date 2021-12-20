<?php


/*
 * parametri richiesti in payload:
 * type: se 0 ritorno gli utenti. se 1 gli admin
 *
 * Questa api ritorna gli utenti del sito
 * */


function adminGetUserList(array $payload, PDO $conn)
{

    if (!isset($_SESSION["username"])) {
        echo json_encode(array("Error" => "User not logged in"));
        exit();
    } else {

        //check user is admin
        $stmtCheckAdmin = $conn->prepare("SELECT * from users where email = :mail");
        $stmtCheckAdmin->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
        $stmtCheckAdmin->execute();
        if($stmtCheckAdmin->rowCount()!=1){
            http_response_code(403);
            echo json_encode(Array("Error"=>"User has no rights for query"));
            exit();
        }

        if($payload["type"] != 0 && $payload["type"] != 1){
            http_response_code(500);
            echo json_encode(array("Error" => "Type not defined"));
            exit();
        }

        try {
            $return = array();
            $stmtGetUsers = $conn->prepare("SELECT email, Name, Surname from users where UserType = :type");
            $stmtGetUsers->bindValue(":type", $payload["type"], PDO::PARAM_STR);
            $stmtGetUsers->execute();

            while (($row = $stmtGetUsers->fetch(PDO::FETCH_ASSOC)) != null) {
                $return[] = $row;
            }
            echo json_encode($return);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("Error" => $e));
            exit();
        }

    }

}
