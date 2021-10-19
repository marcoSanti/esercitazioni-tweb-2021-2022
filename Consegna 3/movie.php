<?php
    if(!isset($_GET['title'])) {
        $title = '';
    }else{
        $title = $_GET['title'];
    }


    if(!file_exists('./moviefiles/' . $title .'/')){ //se il film non esiste metto il primo della lista
        $title = str_replace("./moviefiles/", "", glob('./moviefiles/*')[0]);
    }

    $moviePicPath = './moviefiles/' . $title . '/overview.png';
    $movieInfo = file('./moviefiles/' . $title . '/info.txt');

    $overview = array();
    $overviewInput = file('./moviefiles/' . $title . '/overview.txt');

    foreach ($overviewInput as $tmp){
        $tmp = explode(':', $tmp);
        $overview[$tmp[0]] = Array($tmp[0],$tmp[1]); //array indicizzato non con i numeri
    }

    //metto i br per ogni cast member
    $overview['STARRING'][1] = str_replace(",", '<br>', $overview['STARRING'][1]);

    $reviewNames = glob('./moviefiles/' . $title . '/review*.txt');
    $review = Array();

    foreach ($reviewNames as $reviewName) {
        $review[] = file($reviewName);
    }


?>

<!DOCTYPE html>
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
                if($movieInfo[2] >=60){
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
            for($i=0; $i < count($review)/2 ; $i++){
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
            for($i=(count($review) / 2)+1; $i < count($review) ; $i++){
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
		<p>(1-10) of 88</p>
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