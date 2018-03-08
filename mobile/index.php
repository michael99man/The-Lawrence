<?php
header('Content-type: text/html; charset=utf-8');
ini_set('default_charset', 'utf-8');
require $_SERVER['DOCUMENT_ROOT'] . "/connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$result = $conn->query("SELECT * FROM featured ORDER BY 1");
$out = "";

//sliders
while($post = $result->fetch_assoc()){
    $id = $post["ID"];
    $data = $conn->query("SELECT * FROM articles WHERE ID = \"{$id}\"");
    $data = $data->fetch_assoc();

    $link = "/pictures/placeholders/" . $data["Section"] . ".jpg";
    if($data["Image"] == 1){
        $link = "/pictures/featured/" . $data["ID"] . ".jpg";
        /*if(!file_exists($link)){
                $link = "/pictures/placeholders/" . $data["Section"] . ".jpg";
            }*/
    };
    $blur = "";
    $class = "white";
    $val = 0;
    if($post["white"] == 0){
        $class = "notwhite";
        $blur = "blur";
        $val = 8;
    }

    $shadow = "";
    //black text, no shadow
    if(isset($post["blur"])){
        $val = $post["blur"];
    } else {
        //white text, black shadow
        //$shadow = "text-shadow: 2px 2px 4px black;";
    }
    $out .= "<li class=\"{$class}\"><img class=\"{$blur}\" style = \"-webkit-filter:blur({$val}px);\" src=\"{$link}\" alt=\"\"><div class=\"animated_item text_1_1\" data-animation-show=\"fadeInUp\" data-animation-hide=\"fadeOutDown\"{$data["Section"]}</div><div class=\"animated_item text_1_2\" data-animation-show=\"fadeInUp\" data-animation-hide=\"fadeOutDown\" style = \"{$shadow}\">{$data["Title"]}</div><div class=\"animated_item text_1_3\" data-animation-show=\"fadeInUp\" data-animation-hide=\"fadeOutDown\"><a href=\"article.php?id={$id}\" class=\"general_button_type_1\">Read More</a></div></li>";
}
$out= mb_convert_encoding($out, "UTF-8");

//latest grid
$sections = array("news","editorial","opinions","features","arts","sports");
$latest = "";

foreach($sections as $sec){
    if($sec == "editorial"){
        $data = $conn->query("SELECT * FROM articles WHERE section =\"{$sec}\" ORDER BY Date DESC LIMIT 0,1");
    } else {
        $data = $conn->query("SELECT * FROM articles WHERE section =\"{$sec}\" and Image = \"1\" ORDER BY Date DESC LIMIT 0,1");
    }

    $data = $data->fetch_assoc();
    $date = date_create($data["Date"]);
    $dateString = date_format($date,"F d, Y");

    $link = "/pictures/placeholders/" . $data["Section"] . ".jpg";
    $article_link = "article.php?id={$data["ID"]}";
    if($data["Image"] == 1){
        $link = "/pictures/articles/" . $data["ID"] . ".jpg";
    }
    $author = $data["Author"];

    /* FIRST TWO SENTENCES
        $html_string = file_get_contents("articles/".$data["ID"].".html");
        $string = strip_tags($html_string);
        $intro = tease($string);
        */
    $val = array_search($sec,$sections) +1; 
    $section_link = "section.php?cat=" . $val;
    //PIC POST FOLLOWED BY THREE LIST ELEMENTS

    $heavy = "";
    $textshadow = "";
    //extra hard shading
    if($sec=="opinions"){
        $heavy = "shade-heavy";
        $textshadow = "text-shade";
    }
    $lowercase = strtolower($sec);
    $uppercase = strtoupper($sec);
    $firstupper = ucfirst($sec);

    $upperauthor = strtoupper($author);
    $latest .= "<a class='section-title' href='{$section_link}'><span class='tag {$lowercase}'>{$firstupper}</span></a>";

    $latest .= "<div class='pic-post'>

                                        <div class='pic-container'>
                                            <img src='{$link}' class='section-pic'>
                                            <div class='pic-shade {$heavy}'></div>
                                        </div>
                                        <div class='pic-overlay'>
                                            <a class='pic-title {$textshadow}' href='{$article_link}'>{$data["Title"]}</a>
                                            <a class='section-post'>
                                                <span class='tag {$lowercase}' style='color:#d3d3d3;'>{$upperauthor}</span>
                                            </a>
                                        </div>
                                    </div>";
    //next three
    $list_results = $conn->query("SELECT * FROM articles WHERE section =\"{$sec}\" and ID != \"{$data["ID"]}\" ORDER BY Date DESC LIMIT 0,3");
    while($post = $list_results->fetch_assoc()){
        $uppercase = strtoupper($sec);
        $article_link = "article.php?id={$post["ID"]}";
        $upperauthor = strtoupper($post["Author"]);

        $latest .= "<li class='list-element'>
                                        <div class='post'>
                                            <div>
                                                <a class='title' href='{$article_link}'>{$post["Title"]}</a>

                                            </div>

                                            <a class='section-post' href='{$section_link}'>
                                                <span class='tag {$lowercase}'>{$upperauthor}</span>
                                            </a>
                                        </div>
                                    </li>";
    }
}
//<!--<span class='author'>{$post["Author"]}</span>-->
?>

<!DOCTYPE html>
<html>

    <head>
        <title>The Lawrence</title>

        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta id="section" content = "Home">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

        <link rel="stylesheet" href="layout/css/style.css" type="text/css">
        <link rel="stylesheet" href="layout/css/style2.css" type="text/css">

        <script type="text/javascript" src="layout/js/jquery.js"></script>
        <script type="text/javascript" src="layout/js/plugins.js"></script>

        <script type="text/javascript" src="layout/js/main.js"></script>
    </head>

    <body class="sticky_footer">
        <div class="wrapper">
            <!-- HEADER BEGIN -->
            <?php include 'header.php'?>
            <!-- HEADER END -->

            <!-- CONTENT BEGIN -->
            <div id="content" class="">
                <div class="inner">
                    <div class="block_slider_type_1 general_not_loaded">
                        <div id="slider" class="slider flexslider">
                            <ul class="slides">
                                <?php echo $out?>
                            </ul>
                        </div>

                        <script type="text/javascript">
                            jQuery(function() {
                                init_slider_1('#slider');
                            });
                        </script>
                    </div>

                    <div class="block_posts">
                        <div class="posts">
                            <!-- FIRST -->
                            <div class="section-container">
                                <!-- each section has a section title, then a post with picture -->
                                <!-- inspired by bbc.co.uk -->
                                <ul class="section-list">
                                    <?php echo $latest; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CONTENT END -->

                <!-- FOOTER BEGIN -->
                <?php include 'footer.php'?>
                <!-- FOOTER END -->
            </div>
        </div>
    </body>
</html>