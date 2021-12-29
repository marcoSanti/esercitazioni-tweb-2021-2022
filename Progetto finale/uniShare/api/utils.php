<?PHP

function admin_check($conn){
    $stmtCheckAdmin = $conn->prepare("SELECT * from users where email = :mail and UserType = 1");
    $stmtCheckAdmin->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
    $stmtCheckAdmin->execute();
    if($stmtCheckAdmin->rowCount()!=1){
        jsonReturnEcho(403, "Error", "User has no rights for query");
    }
}

function jsonEcho($a, $b){
    if(__DEBUG__){
        echo json_encode(Array($a=>$b));
    }else{
        echo json_encode(Array($a=>"A server error has occured. please contact the administrator to get assitance...")); //se non ho debug attivom stampo comunque il motivo ma non il messaggio specifico!
    }
}

function jsonReturnEcho($status, $a, $b){
    http_response_code($status);
    jsonEcho($a, $b);
    exit();
}

function jsonReturnOkEcho(){
    jsonReturnEcho(200, "Ok", "Done");
}

function loginCheck(){
    if(!isset($_SESSION["username"])) jsonReturnEcho(403, "Error", "User not logged in!");
}


?>