<?php
header("Content-Type: text/javascript");
$dbConstructor = "mysql:dbname=imdb;host=localhost:3306";
try{
    $dbConnection = new PDO($dbConstructor, "root", "");
}catch (PDOException $e){echo json_encode($e);}

if(isset($_GET["kevin"])) {
    $query = "SELECT movies.name, movies.year FROM (((actors AS a1 INNER JOIN roles AS r1 ON (a1.id = r1.actor_id) ) INNER JOIN( actors AS a2 INNER JOIN roles AS r2 ON  (a2.id = r2.actor_id) ) ON (r1.movie_id = r2.movie_id) )  INNER JOIN movies ON (r1.movie_id = movies.id) ) WHERE a1.first_name = 'Kevin' AND a1.last_name = 'Bacon' AND a2.first_name = :nam AND a2.last_name = :sur;";
}else{
    $query = "SELECT DISTINCT
    movies.name,
    movies.year
FROM
    (
        (
            actors
        INNER JOIN roles ON actors.id = roles.actor_id
        )
    INNER JOIN movies ON(roles.movie_id = movies.id)
    )
WHERE
    actors.first_name = :nam AND actors.last_name = :sur
ORDER BY
    movies.year";
}

if(isset($_GET["firstname"]) && isset($_GET["lastname"])){
    $actorName = $_GET["firstname"];
    $actorSurName = $_GET["lastname"];
}else{
    echo json_encode(Array("Error"=>"Data Not Provided!"));
    exit();
}
try {
       $stmt=$dbConnection->prepare($query);
       $stmt->bindValue(':nam', $actorName);
       $stmt->bindValue(':sur', $actorSurName);
       $stmt->execute();

       echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

}catch (PDOException $e){echo json_encode($e); }


?>


