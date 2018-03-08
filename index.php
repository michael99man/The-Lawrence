    <?php
    header('Content-type: text/html; charset=utf-8');
    ini_set('default_charset', 'utf-8');
    require "connect.php";

    $result = $conn->query("SELECT * FROM featured ORDER BY 1");
    $out = "";

    //sliders
    while($post = $result->fetch_assoc()){
        $id = $post["ID"];
        $data = $conn->query("SELECT * FROM articles WHERE ID = \"{$id}\"");
        $data = $data->fetch_assoc();

        $link = "pictures/placeholders/" . $data["Section"] . ".jpg";
        if($data["Image"] == 1){
            $link = "pictures/featured/" . $data["ID"] . ".jpg";
            if(!file_exists($link)){
                $link = "pictures/placeholders/" . $data["Section"] . ".jpg";
            }
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
        
        $link = "pictures/placeholders/" . $data["Section"] . ".jpg";
        $article_link = "article.php?id={$data["ID"]}";
        if($data["Image"] == 1){
            $link = "pictures/articles/" . $data["ID"] . ".jpg";
            if(!file_exists($link)){
                $link = "pictures/placeholders/" . $data["Section"] . ".jpg";
            }
        };
        $author = $data["Author"];

        /* FIRST TWO SENTENCES
        $html_string = file_get_contents("articles/".$data["ID"].".html");
        $string = strip_tags($html_string);
        $intro = tease($string);
        */
        $latest .= "<article class=\"post_type_1\">
                                        <div class=\"feature\">
                                            <div class=\"image\">
                                                <a href=\"{$article_link}\"><img src=\"{$link}\" alt=\"\"><span class=\"hover\"><h2 class =\"pic_text\">{$author}</h2></span></a>
                                            </div>
                                        </div>

                                        <div class=\"content\">
                                            <div class=\"info\">
                                                <div class=\"tags {$data["Section"]}\">{$data["Section"]}</div>
                                                <div class=\"date\">{$dateString}</div>
                                            </div>

                                            <div class=\"title\">
                                                <a href=\"{$article_link}\">{$data["Title"]}</a>
                                            </div>
                                        </div>
                                    </article>";
    }


    function tease($body, $sentencesToDisplay = 2) {
        $nakedBody = preg_replace('/\s+/',' ',strip_tags($body));
        $sentences = preg_split('/(\.|\?|\!)(\s)/',$nakedBody);

        if (count($sentences) <= $sentencesToDisplay)
            return $nakedBody;

        $stopAt = 0;
        foreach ($sentences as $i => $sentence) {
            $stopAt += strlen($sentence);

            if ($i >= $sentencesToDisplay - 1)
                break;
        }

        $stopAt += ($sentencesToDisplay * 2);
        return trim(substr($nakedBody, 0, $stopAt));
    }
?>
<!DOCTYPE html>
<html>

    <head>
        <title>The Lawrence</title>
            <meta name="keywords" content="">
            <meta name="description" content="">
            <link rel="icon" href="/favicon.ico">
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <meta id="section" content = "Home">
            <!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

            <link rel="stylesheet" href="layout/style.css" type="text/css">

            <script type="text/javascript" src="layout/js/jquery.js"></script>
            <script type="text/javascript" src="layout/js/plugins.js"></script>

            <script type="text/javascript" src="layout/js/main.js"></script>

            </head>

        <body class="sticky_footer">
            <div class="wrapper">
                <!-- HEADER BEGIN -->
                <?php include 'header.php'; ?>
                <!-- HEADER END -->

                <!-- CONTENT BEGIN -->
                <div id="content" class="">
                    <div class="inner">
                        <div class="block_slider_type_1 general_not_loaded">
                            <div id="slider" class="slider flexslider">
                                <ul class="slides">
                                    <?php echo $out ?>
                                </ul>
                            </div>

                            <script type="text/javascript">
                                jQuery(function() {
                                    init_slider_1('#slider');
                                });
                            </script>
                        </div>

                        <div class="block_general_title_1 w_margin_1">
                            <h1>Latest Articles</h1>
                            <h2>Read the newest published articles</h2>
                        </div>

                        <div class="block_posts type_1 type_sort general_not_loaded">
                            <div class="posts">
                                <?php echo $latest?>
                            </div>
                        </div>

                    </div>

                    <!-- CONTENT END -->

                    <!-- FOOTER BEGIN -->
                    <?php include 'footer.php'; ?>
                    <!-- FOOTER END -->
                </div>
            </div>
        </body>
        </html>