<?php
try{
    ini_set('default_charset', 'utf-8');
    header('Content-type: text/html; charset=utf-8');
    require $_SERVER['DOCUMENT_ROOT'] . "/connect.php";
    $id = $_GET["id"];
    $result = $conn->query("SELECT * FROM articles WHERE ID = \"" . $id . "\";");
    $result = $result->fetch_assoc();

    //Fetch data from array
    $title = $result["Title"];
    $author = $result["Author"];
    $date = date_create($result["Date"]);
    $section = $result["Section"];
    $caption = $result["Caption"];

    $placeholder = "/pictures/placeholders/{$section}.jpg"; 
    //SWITCH PLACEHOLDERS FOR SECTION! 

    if($result["Image"]==1){
        $link = "/pictures/articles/" . $id. ".jpg";
    } else {
        $link = $placeholder;
    }

    //temp workaround
    if($section == "Nation & World"){
        $link = "/pictures/placeholders/News.jpg";
    }

    $sections = array("News","Editorial","Opinions","Features","Arts","Sports","Nation & World");
    $val = array_search($section,$sections) +1;

    $date = date_format($date,"F d, Y");
} catch (Exception $e){
    echo "Ruh roh!\n" . $e->getMessage();
}
$authorLink = str_replace(" ", "+",$author)."&type=author&section=all&age=all";
?>

<!DOCTYPE html>
<html>

    <head>
        <title>The Lawrence - <?php echo $title ?></title>

        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="icon" href="/favicon.ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta id="section" content = "Article">
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
            <?php include 'header.php' ?>
            <!-- HEADER END -->

            <!-- CONTENT BEGIN -->
            <div id="content">
                <div class="inner">
                    <div class="block_general_title_2">
                        <h1 style="padding-top: 3vh; padding-bottom:1vh;"><?php echo $title?></h1>

                        <?php
    echo "<h2><span class=\"author\">by <a href=\"/search.php?query={$authorLink}\">{$author}</a></span></h2>
    <h2><span class=\"date\">{$date}</span></h2>";
                        ?>

                    </div>

                    <div class="main_content">
                        <div class="block_content">
                            <?php echo "<table class=\"pic\"><caption align=\"bottom\" class=\"caption\">{$caption}</caption><tbody><tr><td><img src=\"{$link}\" class = \"article_pic\"></td></tr></tbody></table>"; ?>
                            <div class="text_body"><?php include $_SERVER['DOCUMENT_ROOT']. "/articles/{$id}.html"; ?></div> 
                            <div class="line_1"></div>
                        </div>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </div>
            <!-- CONTENT END -->

            <!-- FOOTER BEGIN -->
            <?php include 'footer.php'; ?>
            <!-- FOOTER END -->
        </div>
    </body>

</html>