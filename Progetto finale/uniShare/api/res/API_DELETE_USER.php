<?php


/*
 * parametri richiesti in payload:
 *
 * userId : user da eliminare
 *
 * Questa api consente a un amministratore di eliminare un utente andando a eliminare tutte le informazioni correlate a quell'utente prima
 * */


function deleteUser(array $payload, PDO $conn)
{

    loginCheck();
        try{
            admin_check($conn);


            if($payload["userId"] == $_SESSION["username"]){
                jsonReturnEcho(400, "Error", "Cannot delete yourself");
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
           jsonReturnOkEcho();

        }catch(PDOException $e){jsonReturnEcho(500, "Error", $e);}
    }
