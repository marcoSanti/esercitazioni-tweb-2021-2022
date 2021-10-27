<?php

include "top.html";
/*
 * This function return whether two personalities are
 * compatible by looking if al least one letter of the first is included in the second
 *
 * @param The first personality
 * @param Ths second personality
 *
 * @return true if they are compatible. false otherwise
 * */
function personalityAreCompatible($a, $b): bool
{
    $lengthA = strlen($a);
    $compatible = false;
    for($i=0;$i<$lengthA; $i++){
        $compatible = str_contains($b, $a[$i]) || $compatible;
    }
    return $compatible;
}

//obtaining username with get. if it is not set, it is set to empty string
$username = $_GET['name'] ?? '';

/*
 * if the username is empty, i include the bottom.html and exit from the execution of the script
 */
if($username == ''){
    include 'bottom.html';
    exit();
}

$input = file('singles.txt', FILE_SKIP_EMPTY_LINES);

$people  = array();
$myPerson = array();
$personalInformations = array();

/*
 * Loading file into a multidimensional array
 * */
foreach ($input as $item)
    $people[] = explode(",", $item);

/*
 * Obtaining personal user information
 * */
foreach ($people as $person)
    if($person[0] == $username)
        $personalInformations = $person;

/*
 * check that personal information is not empty
 * if it is, a query for a non existing user has been done
 * */

if(!isset($personalInformations[0])){
    ?>
        <fieldset class="errorMessage">
            <legend>Warning!</legend>
            <p>User <?= $username ?> is not a registered user in the application!</p>
        </fieldset>
    <?php
    include 'bottom.html';
    exit();
}
?>

<strong>Matches for <?= $username ?></strong>

<?php
/*
 * Here i check that two people are compatible. if they are,
 * i print a "Compatible card"
 */
foreach ($people as $person){
    if(
        ($person[0] != $personalInformations[0]) && //not itself
        ($person[1] != $personalInformations[1]) && //different sex
        ($person[2] >= $personalInformations[5]) && //age higher than min age
        ($person[2] <= $personalInformations[6]) && //age lower than max age
        ($person[4] == $personalInformations[4]) && //same OS
        personalityAreCompatible($person[3], $personalInformations[3]) //check if personalities are compatible
    ){
        ?>
        <div class="match">
            <p><?= $person[0] ?></p>
            <img src=" https://www.cs.washington.edu/education/courses/cse190m/12sp/homework/4/user.jpg" alt="User profile pic">
            <ul>
                <li>
                    <strong>Gender:</strong><?= $person[1] ?>
                </li>
                <li>
                    <strong>Age:</strong><?= $person[2] ?>
                </li>
                <li>
                    <strong>Type:</strong><?= $person[3] ?>
                </li>
                <li>
                    <strong>OS:</strong><?= $person[4] ?>
                </li>
            </ul>
        </div>
        <?php

    }
}

include "bottom.html";
?>