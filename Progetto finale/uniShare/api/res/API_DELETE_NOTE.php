<?php


/*
 * parametri richiesti in payload:
 *
 * noteId: id dell'appunto da elminare
 * 
 * Questa api ritorna gli utenti del sito
 * */


function deleteNote(array $payload, PDO $conn)
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

            $stmtDeleteReviews = $conn->prepare("DELETE FROM recensione where appunto = :appunto");
            $stmtDeleteReviews->bindValue(":appunto", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteReviews->execute();

            $stmtDeleteAcquisto = $conn->prepare("DELETE FROM acquisto WHERE appunto = :appunto");
            $stmtDeleteAcquisto->bindValue(":appunto", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteAcquisto->execute();

            $stmtGetFileName = $conn->prepare("SELECT path from appunti where idappunti = :id");
            $stmtGetFileName->bindValue(":id", $payload["noteId"], PDO::PARAM_INT);
            $stmtGetFileName->execute();
            $path = $stmtGetFileName->fetch(PDO::FETCH_ASSOC)["path"];
            unlink("../uploads/" . $path . ".pdf");

            $stmtDeleteNote = $conn->prepare("DELETE FROM appunti WHERE idappunti = :id");
            $stmtDeleteNote->bindValue(":id", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteNote->execute();

            echo json_encode(Array("Ok" => "Done"));

        }catch(PDOException $e){echo json_encode(Array("Error"=>$e)); }
    }
}