<?php


/*
 * parametri richiesti in payload:
 * type: se 0 ritorno gli utenti. se 1 gli admin
 *
 * Questa api ritorna gli utenti del sito
 * */


function adminGetUserList(array $payload, PDO $conn)
{

    loginCheck();

        try {
            admin_check($conn);

            if($payload["type"] != 0 && $payload["type"] != 1){
               jsonReturnEcho(500, "Error", "Type is not valid");
            }

            $return = array();
            $stmtGetUsers = $conn->prepare("SELECT email, Name, Surname from users where UserType = :type");
            $stmtGetUsers->bindValue(":type", $payload["type"], PDO::PARAM_STR);
            $stmtGetUsers->execute();

            while (($row = $stmtGetUsers->fetch(PDO::FETCH_ASSOC)) != null) {
                $return[] = $row;
            }
            echo json_encode($return);
        } catch (PDOException $e) { jsonReturnEcho(500, "Error", $e); }

    }


