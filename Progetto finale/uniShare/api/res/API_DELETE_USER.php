<?php


/*
 * parametri richiesti in payload:
 *
 * userId : user da eliminare
 *
 * Questa api ritorna gli utenti del sito
 * */


function deleteUser(array $payload, PDO $conn)
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

            if($payload["userId"] == $_SESSION["username"]){
                echo json_encode(Array("Error"=>"Cannot delete yourself"));
                exit();
            }

            $stmtGetFileUploaded = $conn->prepare("SELECT path from appunti where user = :user;");
            $stmtGetFileUploaded->bindValue(":user", $payload["userId"], PDO::PARAM_STR );
            $stmtGetFileUploaded->execute();

            while( $item = $stmtGetFileUploaded->fetch(PDO::FETCH_ASSOC)){
                unlink("../uploads/" . $item["path"] . ".pdf");
            }

            $stmtDropUser = $conn->prepare("delete from recensione where appunto in (
                                                        select idappunti from appunti where user = :user
                                                    ) or acquisto in (
                                                        select ID_acquisto from acquisto where user = :user
                                                    );
                                                    delete from acquisto where appunto in(
                                                        select idappunti from appunti where user = :user
                                                    ) or user = :user;
                                                    delete from appunti where user = :user;
                                                    delete from dashboard where user = :user;
                                                    delete from users where email = :user;
            ");

            $stmtDropUser->bindValue(":user", $payload["userId"], PDO::PARAM_STR);
            $stmtDropUser->execute();
            echo json_encode(Array("Ok"=>"Done"));

        }catch(PDOException $e){echo json_encode(Array("Error"=>$e));}
    }
}