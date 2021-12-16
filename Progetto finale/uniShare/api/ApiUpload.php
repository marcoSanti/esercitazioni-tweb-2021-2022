<?php

header("Content-Type: text/javascript");

if(!@require_once "config.php"){
    http_response_code(500);
    echo json_encode(Array("Error" => "Unable to include config file!"));
    exit();
}


if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION["username"])){
    http_response_code(400);
    echo json_encode(Array("Error"=>"User not logged in!"));
    exit();
}

$universita = htmlspecialchars($_POST["universita"]);
$annoCorso = htmlspecialchars($_POST["annoCorso"]);
$insegnamento = htmlspecialchars($_POST["insegnamento"]);
$tipoAppunti = htmlspecialchars($_POST["tipoDiAppunti"]);
$nomeDocente = htmlspecialchars($_POST["nomeDelDocente"]);
$titoloAppunti = htmlspecialchars($_POST["titoloAppunti"]);

$idScuola = null; //riempito dopo con query
$idCorso = null; //riempito dopo con query
$newFileName = "";
$file = $_FILES["uploadFile"];
if (UPLOAD_ERR_OK === $file['error']) {
    $fileName = basename($file['name']);
    $newFileName =  hash_file("sha256", $file['tmp_name']  )  . time() . '.pdf';
    move_uploaded_file($file['tmp_name'],  "../uploads/" . $newFileName);
}else{
    http_response_code(500);
    echo json_encode(Array("Error" => "Unable to upload file"));
}


try{
    //ottengo id scuola
    $stmtGetScuola = $conn->prepare("SELECT idScuola FROM scuola WHERE nomeScuola = :name");
    $stmtGetScuola->bindValue(":name", $universita, PDO::PARAM_STR);
    $stmtGetScuola->execute();
    if($stmtGetScuola->rowCount()>0){
        $idScuola = $stmtGetScuola->fetch(PDO::FETCH_ASSOC)["idScuola"];
    }else{ //inserisco l'università
        $stmtInsertScuola = $conn->prepare("INSERT INTO scuola (nomeScuola) VALUES (:name);");
        $stmtInsertScuola->bindValue(":name", $universita, PDO::PARAM_STR);
        $stmtInsertScuola->execute();

        //ottengo l'ultimo valore del campo con AUTO_INCREMENT nel db
        $stmtGetScuola->execute();
        $idScuola = $stmtGetScuola->fetch(PDO::FETCH_ASSOC)["idScuola"];
    }


    //ottengo id corso
    $stmtGetInsegnamento = $conn->prepare("SELECT idInsegnamento as id FROM insegnamento WHERE scuola = :idScuola and Nome = :nomeCorso LIMIT 1");
    $stmtGetInsegnamento->bindValue(":idScuola", $idScuola, PDO::PARAM_STR);
    $stmtGetInsegnamento->bindValue(":nomeCorso", $insegnamento, PDO::PARAM_STR);
    $stmtGetInsegnamento->execute();
    if($stmtGetInsegnamento->rowCount()>0){
        $idCorso = $stmtGetInsegnamento->fetch(PDO::FETCH_ASSOC)["id"];
    }else{ //inserisco l'università
        $stmtInsertInsegnamento = $conn->prepare("INSERT INTO insegnamento (nome, scuola) VALUES (:name, :scuola);");
        $stmtInsertInsegnamento->bindValue(":name", $insegnamento, PDO::PARAM_STR);
        $stmtInsertInsegnamento->bindValue(":scuola", $idScuola, PDO::PARAM_STR);
        $stmtInsertInsegnamento->execute();
        //ottengo l'ultimo valore del campo con AUTO_INCREMENT nel db
        $stmtGetInsegnamento->execute();
        $idCorso = $stmtGetInsegnamento->fetch(PDO::FETCH_ASSOC)["id"];
    }

    /*
     * ATTENZIONE
     * qua calcolo il prezzo del documento: idealmente dovrebbe essere fatto calcolando il numero di
     * pagine del documento, usando una estensione come imagemagick, ma questo richiede
     * l'installazione del plugin, quindi prendo la dimensione del file come se fosse il numero delle pagine...
     *
     * il prezzo è tre centesimi a pagina, di cui due a utente e uno a gestore sito...
     * */
    $price = 0.03 * ($file["size"] / 1024); //size in kb

    //inserisco l'appunto a database
    $stmtInsertAppunto = $conn->prepare( "insert into appunti (Nome, Path, price, insegnamento_scuola, user, tipoAppunti, nomeDocente) VALUES (:nomeAppunti, :pathAppunti,:prezzo,  :corso, :username, :tipo, :docente);");
    $stmtInsertAppunto->bindValue(":nomeAppunti", $titoloAppunti, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":pathAppunti",  "../uploads/" . $newFileName, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":prezzo", $price, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":corso", $idCorso, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":username", $_SESSION["username"], PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":tipo", $tipoAppunti, PDO::PARAM_INT);
    $stmtInsertAppunto->bindValue(":docente", $nomeDocente, PDO::PARAM_STR);
    $stmtInsertAppunto->execute();

    echo json_encode(Array("Ok"=>"Added!"));

}catch(PDOException | ImagickException $e){
    http_response_code(500);
    unlink("../uploads/" . $newFileName); //delete file if error occurs
    echo json_encode(Array("Error" => $e));
    exit();
}

?>