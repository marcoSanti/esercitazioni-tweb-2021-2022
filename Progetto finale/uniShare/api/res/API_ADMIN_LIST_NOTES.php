<?php


/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna gli utenti del sito
 * */


function listDocuments(array $payload, PDO $conn)
{

    if (!isset($_SESSION["username"])) {
        echo json_encode(array("Error" => "User not logged in"));
        exit();
    } else {

        $stmtCheckAdmin = $conn->prepare("SELECT * from users where email = :mail");
        $stmtCheckAdmin->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
        $stmtCheckAdmin->execute();
        if($stmtCheckAdmin->rowCount()!=1){
            http_response_code(403);
            echo json_encode(Array("Error"=>"User has no rights for query"));
            exit();
        }

        try {
            $return = array();
            $stmtGetUsers = $conn->prepare("SELECT idappunti, nome, user, Path, price from appunti");
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
