<?php

/**
 * Questa api contiene il codice per gestire l'upload di un documento a server.
 * Viene gestitia in modo diverso in quanto la codifica dei dati è per forza form-encoded e non json
 */

header("Content-Type: text/javascript");

if(!@require_once "utils.php"){
    http_response_code(500);
    echo json_encode(Array("Error" => "Unable to load utilities!"));
    exit();
}

if(!@require_once "config.php"){
    jsonReturnEcho(500, "Error", "Unable to include config file!");
}


/**
 * Questa funzione calcola il numero di pagine di un documento pdf
 */
function countPages($path) {
    $pdftext = file_get_contents($path);
    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
    return $num;
}


if (!isset($_SESSION)) { session_start(); }

loginCheck();

//filtro caratteri html dell'input utente
$universita = htmlspecialchars($_POST["universita"]);
$annoCorso = htmlspecialchars($_POST["annoCorso"]);
$insegnamento = htmlspecialchars($_POST["insegnamento"]);
$tipoAppunti = htmlspecialchars($_POST["tipoDiAppunti"]);
$nomeDocente = htmlspecialchars($_POST["nomeDelDocente"]);
$titoloAppunti = htmlspecialchars($_POST["titoloAppunti"]);


$file = $_FILES["uploadFile"];
if ($file['error']===UPLOAD_ERR_OK) {

    //controllo estensione del file
    if(pathinfo($file["name"], PATHINFO_EXTENSION) != "pdf"){
        jsonReturnEcho(403, "Error", "File extension not allowed");
    }

    $newFileName =  hash_file("sha256", $file['tmp_name']  ) . time()  ;
    move_uploaded_file($file['tmp_name'],  "../uploads/" . $newFileName. '.pdf');
}else{
    jsonReturnEcho(500,"Error" , "Unable to upload file");
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
     * qua calcolo il prezzo del documento.
     *
     * il prezzo è tre centesimi a pagina, di cui due a utente e uno a gestore sito...
     * */

     $price = countPages("../uploads/" . $newFileName. '.pdf') * 0.03;
    

    //inserisco l'appunto a database
    $stmtInsertAppunto = $conn->prepare( "INSERT into appunti (Nome, Path, price, insegnamento_scuola, user, tipoAppunti, nomeDocente) VALUES (:nomeAppunti, :pathAppunti,:prezzo,  :corso, :username, :tipo, :docente);");
    $stmtInsertAppunto->bindValue(":nomeAppunti", $titoloAppunti, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":pathAppunti",  $newFileName, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":prezzo", $price, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":corso", $idCorso, PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":username", $_SESSION["username"], PDO::PARAM_STR);
    $stmtInsertAppunto->bindValue(":tipo", $tipoAppunti, PDO::PARAM_INT);
    $stmtInsertAppunto->bindValue(":docente", $nomeDocente, PDO::PARAM_STR);
    $stmtInsertAppunto->execute();

    jsonReturnOkEcho();

}catch(PDOException $e){
    unlink("../uploads/" . $newFileName); //delete file if error occurs
    jsonReturnEcho(500, "Error", $e);
}

?>