<?php
require_once("top.html");


/*
 * Here i check if the post is provided, if not I exit the execution and I show a message
*/
if(!(
        isset($_POST['name']) &&
        isset($_POST['persType']) &&
        isset($_POST['age']) &&
        isset($_POST['ageTo']) &&
        isset($_POST['ageFrom']) &&
        isset($_POST['gender']) &&
        isset($_POST['os'])
)){
    ?>
    <fieldset class="errorMessage">
        <legend>Error!</legend>
        <p>The form was not submitted correctly!</p>
    </fieldset>
    <?php
    include 'bottom.html';
    exit();
}


/*
 * Here I do some filetr input for all the user input
 */
$name = str_replace(",", " " ,$_POST['name']);
$persType = str_replace(","," " , $_POST['persType']);
$age = intval($_POST['age']);
$ageFrom = intval($_POST['ageFrom']);
$ageTo = intval($_POST['ageTo']);


/*
 * Here I create the string to be written into the file. at the beginning i use a PHP_EOL (\n)
 * because if someone has edited the file and removed last \n, the new line might get
 * appended on the same last line and not on a new line.
 * I will just need check if the string is empty when I eill read the file!
 * */
$stringFormatted  = PHP_EOL . $name . ',' . $_POST['gender'] . ',' .  $age;
$stringFormatted .= ',' . $persType . ',' . $_POST['os'];
$stringFormatted .= ',' . $ageFrom . ',' . $ageTo;

file_put_contents('./singles.txt', $stringFormatted, FILE_APPEND);


?>

    <div>
        <strong>
            Tank you!
        </strong>
    </div>
    <div>
        Welcome to NerdLub, <?= $_POST["name"] ?>!
    </div>
    <div>
        Now <a href="matches.php">Log in to see your matches!</a>
    </div>

<?php


require_once("bottom.html");
?>