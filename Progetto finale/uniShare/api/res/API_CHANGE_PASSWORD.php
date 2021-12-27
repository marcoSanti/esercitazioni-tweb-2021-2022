<?php


/*
 * parametri richiesti in payload:
 * oldPassword: id appunto della recensione
 * newPassword: valore della recensione
 *
 * Questa api ritorna gli utenti del sito
 * */


function updatePassword(array $payload, PDO $conn)
{

    if (!isset($_SESSION["username"])) {
        echo json_encode(array("Error" => "User not logged in"));
        exit();
    } else {
        try{
           $stmtSelectOldPaswword = $conn->prepare("SELECT password from users where email = :user");
           $stmtSelectOldPaswword->bindValue(":user", $_SESSION["username"],PDO::PARAM_STR);
           $stmtSelectOldPaswword->execute();

           $oldPassword = $stmtSelectOldPaswword->fetch(PDO::FETCH_ASSOC)["password"];

           if($oldPassword == hash("sha512", $payload["oldPassword"])){
                $stmtUpdatePassword = $conn->prepare("UPDATE users SET password = :password WHERE email = :user");
                $stmtUpdatePassword->bindValue(":password",hash("sha512", $payload["newPassword"]) , PDO::PARAM_STR );
                $stmtUpdatePassword->bindValue(":user", $_SESSION["username"], PDO::PARAM_STR);
                $stmtUpdatePassword->execute();
                echo json_encode(Array("Ok"=>"Done"));
           }else{
               echo json_encode(Array("Error"=>"Old password not matching"));
               exit();
           }

        }catch(PDOException $e){echo json_encode(Array("Error"=>$e));}
    }
}