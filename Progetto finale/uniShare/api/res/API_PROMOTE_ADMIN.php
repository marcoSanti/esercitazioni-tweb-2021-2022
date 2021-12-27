<?php


/*
 * parametri richiesti in payload:
 * username -> email user da mettere admin
 *
 * Questa api ritorna gli utenti del sito
 * */


function promote(array $payload, PDO $conn)
{

   loginCheck();

        try{
            admin_check($conn);


            $stmtPromoteUser = $conn->prepare("UPDATE users SET UserType = 1 where email = :mail");
            $stmtPromoteUser->bindValue(":mail", $payload["username"], PDO::PARAM_STR);
            $stmtPromoteUser->execute();

            jsonReturnOkEcho();
        }catch(PDOException $e){jsonReturnEcho(500, "Error", $e);}

}
