<!-- Informazione: le cartelle dei film di default non sono incluse in quanto
nella consegna non era previsto che le suddette fossero caricate sul server remoto
ad eccezione di quella "custom" -->
<?php
/*
 * getting the movie name.
 * if it is not set, the title is obtained by the glob function. To be more precise,
 * I set the title to the name of the first folder in the root folder.
 */
$title = $_GET['film'] ?? array_filter(glob("*"), 'is_dir')[0];

/*
 * here I create the path to the movie image and the movie description file
 */
$moviePicPath = './' . $title . '/overview.png';
$movieInfo = file('./' . $title . '/info.txt');

/*
 * Here I proceed to load all the information of the movie into a string indexed array.
 */
$overview = array();
foreach (file('./' . $title . '/overview.txt') as $tmp) {
    $tmp = explode(':', $tmp);
    $overview[$tmp[0]] = array($tmp[0], $tmp[1]);
}

/*
 * here I do some html preformatting for cast members but only if I have a starring section in the overview array
 */
if (isset($overview['STARRING']))
    $overview['STARRING'][1] = str_replace(",", '<br>', $overview['STARRING'][1]);

/*
 * here I get all the reviews field paths, and I put them inside an array
 */
$review = array();
foreach (glob('./' . $title . '/review*.txt') as $reviewName) {
    $review[] = file($reviewName, FILE_IGNORE_NEW_LINES);
}

//here I declare a number of reviews since I use this value very often it has no sense to evaluate it everytime, as well as its hal
//because that is also computed very often (@ about line 115)
$numOfReviews = count($review);
$halfNumberOfReviews = intval($numOfReviews/2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $movieInfo[0] ?>- Rancid Tomatoes</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="movie.css" type="text/css" rel="stylesheet">
    <link rel="icon" type="image/png" href="https://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif">
</head>
<body>
<div class="header_banner">
    <img src="https://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png" id="bannerbg" alt="Rancid Tomatoes">
</div>
<h1 class="movie_title"><?= $movieInfo[0] . ' ( ' . $movieInfo[1] . ')' ?></h1>
<div class="page_content">
    <div class="right">
        <div>
            <img src="<?= $moviePicPath ?>" alt="general overview" id="movie_image">
        </div>
        <div class="movie_info">
            <dl>
                <?php
                /*
                 * here I print all the overview array content, printing first the heading and then the value
                 * */
                foreach ($overview as $tmp => $item) {
                    ?>
                    <dt><?= $item[0] ?></dt>
                    <dd><?= $item[1] ?></dd>
                    <?php
                }
                ?>
            </dl>
        </div>
    </div>
    <div class="left">
        <div class="rotten_title_header">
            <?php
            if ($movieInfo[2] >= 60) { //only if movie rating is > 60 I print the fresh
                ?>
                <img src="https://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/freshbig.png" alt="Rotten">
                <?php
            } else {
                ?>
                <img src="https://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/rottenbig.png" alt="Rotten">
                <?php
            }
            ?>
            <div class="rotten_evaluation"> <?= $movieInfo[2] . '%' ?> </div>
        </div>
        <div class="review-cols">
            <?php
            for ($i = 0; $i < $numOfReviews; $i++) { //here I print half the review in the first column
                ?>
                <div class="review">
                    <p class="review_box">
                        <img src="https://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= strtolower($review[$i][1]) ?>.gif" alt="Rotten">
                        <q><?= $review[$i][0] ?></q>
                    </p>
                    <p class='review_name'>
                        <img src="https://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
                        <?= $review[$i][2] ?> <br>
                        <span class="editor"><?= $review[$i][3] ?></span>
                    </p>
                </div>
                <?php
                //here I check if half of the reviews have been printed. if so, a new column is started
                if($i == $halfNumberOfReviews){
                ?>
                    </div>
                    <div class='review-cols'>
                <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="bottom">
        <p>(1-<?= $numOfReviews ?>) of <?= $numOfReviews ?></p>
    </div>
</div>
<div class="validation">
    <p>
        <a href="https://validator.w3.org/check/referer">
            <img width="88" src="https://upload.wikimedia.org/wikipedia/commons/b/bb/W3C_HTML5_certified.png" alt="Valid HTML5!">
        </a>
    </p>
    <br>
    <p>
        <a href="https://jigsaw.w3.org/css-validator/check/referer">
            <img src="https://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!">
        </a>
    </p>
</div>
</body>
</html>
