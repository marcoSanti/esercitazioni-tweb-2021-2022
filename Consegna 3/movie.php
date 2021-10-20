<?php

    /*
     * getting the movie name.
     * if it is not set, the title is set no empty string
     */
    if(!isset($_GET['film'])) {
        $title = '';
    }else{
        $title = $_GET['film'];
    }



    /*
     * Here i check that the movie exists. if it does not ( string empy, null or simply the movie folder does not exists),
     * i set the title to the name of the first folder in the root folder.
     * to be more precise, i use glob()[0] to obtain the array with all the folder inside the root folder,and i set that value to the var $title
     * */
    if($title=='' || $title == null || !file_exists( './' .$title .'/')){
        $title =  glob('./*/')[0]; //getting only folders leaving out files
    }

    /*
     * here i create the path to the movie image and the movie description file
     * */
    $moviePicPath = './' .$title . '/overview.png';
    $movieInfo = file('./' . $title . '/info.txt');

    /*
     * Here i proceed to load all the information of the movie into a string indexed array.
     * */

    $overview = array();
    $overviewInput = file( './' .$title . '/overview.txt');

    foreach ($overviewInput as $tmp){
        $tmp = explode(':', $tmp);
        $overview[$tmp[0]] = Array($tmp[0],$tmp[1]);
    }

    /*
     * here i do some html preformatting for cast members but only if i have a starring section in the overview array
     * */
    if(isset($overview['STARRING']))
        $overview['STARRING'][1] = str_replace(",", '<br>', $overview['STARRING'][1]);

    /*
     * here i get all the reviews field paths and i put them inside an array
     * */
    $reviewNames = glob( './' .$title . '/review*.txt');
    $review = Array();
    foreach ($reviewNames as $reviewName) {
        $review[] = file($reviewName);
    }


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
	<img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png" id="bannerbg" alt="Rancid Tomatoes">
</div>
<h1 class="movie_title"><?= $movieInfo[0] . ' ( ' . $movieInfo[1]  . ')' ?></h1>
<div class ="page_content">
	<div class="right">
		<div>
			<img src="<?= $moviePicPath ?>" alt="general overview" id="movie_image">
		</div>
		<div class="movie_info">
			<dl>
                <?php
                /*
                 * here i print all the overview array content, printing first the heading and then the value
                 * */
                    foreach($overview as $tmp => $item){
                        ?>
                        <dt><?= $overview[$tmp][0] ?></dt>
                        <dd><?= $overview[$tmp][1] ?></dd>
                        <?php
                    }
                ?>
			</dl>
		</div>
	</div>
	<div class="left">
		<div class="rotten_title_header">
            <?php
                if($movieInfo[2] >=60){ //only if movie rating is > 60 i print the fresh
                    ?>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/freshbig.png" alt="Rotten">
                    <?php
                }else{
                    ?>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/rottenbig.png" alt="Rotten">
                    <?php
                }
            ?>
            <div class ="rotten_evaluation"> <?= $movieInfo[2] . '%' ?> </div>
		</div>
		<div class="review-cols">

            <?php
            for($i=0; $i < count($review)/2 ; $i++){ //here i print half the review in the first column
                ?>

                <div class="review">
                    <p class="review_box">
                        <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?=str_replace(" ", "", strtolower($review[$i][1])) ?>.gif" alt="Rotten">
                        <q><?= $review[$i][0] ?></q>
                    </p>
                    <p class="review_name">
                        <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
                        <?= $review[$i][2] ?> <br>
                    <div class="editor"><?= $review[$i][3] ?></div>
                    </p>
                </div>

            <?php
            }
            echo "</div> <div class='review-cols'>";
            for($i=(count($review) / 2)+1; $i < count($review) ; $i++){ //here i print the second half of the review in the second column
                ?>

                <div class="review">
                    <p class="review_box">
                        <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?=str_replace(" ", "", strtolower($review[$i][1])) ?>.gif" alt="Rotten">
                        <q><?= $review[$i][0] ?></q>
                    </p>
                    <p class="review_name">
                        <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
                        <?= $review[$i][2] ?> <br>
                    <div class="editor"><?= $review[$i][3] ?></div>
                    </p>
                </div>

            <?php
            }
            ?>
        </div>
    </div>

	<div class="bottom">
		<p>(1-<?= count($review) ?>) of <?= count($review) ?></p>
	</div>
</div>

<div class="validation">
	<p>
		<a href="http://validator.w3.org/check/referer"><img width="88" src="https://upload.wikimedia.org/wikipedia/commons/b/bb/W3C_HTML5_certified.png" alt="Valid HTML5!"></a>
	<p> <br>
		<a href="http://jigsaw.w3.org/css-validator/check/referer"><img img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a>
</div>
</body>
</html>