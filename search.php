<?php
header('Content-type: text/html; charset=utf-8');
ini_set('default_charset', 'utf-8');
require "connect.php";
ini_set('display_errors', 'On');
error_reporting(E_ALL);

if(isset($_GET["type"])){
    $type = $conn->real_escape_string($_GET["type"]);
} else{
    $type = "all";
}

if(isset($_GET["age"])){
    $age = $conn->real_escape_string($_GET["age"]);
} else{
    $age = "all";
}

if(isset($_GET["section"])){
    $sec = $conn->real_escape_string($_GET["section"]);
} else {
    $sec = "all";
}
$mysql_query = "No query.";
$out = "No matches found.";

if(isset($_GET["query"]) && $_GET["query"] !== ""){
    $query = str_replace("\\", "", $_GET["query"]);
    $query = $conn->real_escape_string($query);

    //$age === "all"
    $t = 1200;
    if($age === "week"){
        $t = 7;
    } else if ($age === "month"){
        $t = 31;
    } else if ($age === "year"){
        $t = 365;
    }

    $sec_query = "";
    if($sec !== "all"){
        $sec_query = "AND section = \"{$sec}\" ";
    }


    if($type=="content" || $type=="all"){
        $files = glob("articles/*.html");
        foreach($files as $k=>$file){
            $source= file_get_contents($file);
            if(!stripos($source,$query)){
                unset($files[$k]);
            }
        }

        $vals = array_values($files);
        $ids = preg_replace("/[^0-9]/","",$vals);
        $id_query = join(',',$ids);
         
        if($type =="content"){
            $mysql_query = "SELECT * FROM articles WHERE ID IN ({$id_query}) {$sec_query}AND Date BETWEEN NOW() - INTERVAL {$t} DAY AND NOW() ORDER BY Date DESC";
        } else {
            if(empty($ids)){
                $id_query = "1";
            }
            
            $mysql_query = "SELECT * FROM articles WHERE (ID IN ({$id_query}) OR Title LIKE \"%{$query}%\" OR Author LIKE \"%{$query}%\") {$sec_query} AND Date BETWEEN NOW() - INTERVAL {$t} DAY AND NOW() ORDER BY Date DESC";
        }

        $result = $conn->query($mysql_query);
        $out = "<p>No results found.</p>";
        if($result instanceof mysqli_result){
            if($result->num_rows > 0){
                $out = format($result);
            }
        }
    } else {
        //if type not specified, run keyword search (for header bar)
        $cat = "(Title LIKE \"%{$query}%\" OR Author LIKE \"%{$query}%\")"; 

        //override if specific case chosen
        if ($type === "title"){
            $cat = "(Title LIKE \"%{$query}%\")";
        } else if ($type === "author"){
            $cat = "(Author LIKE \"%{$query}%\")";
        }
        $mysql_query = "SELECT * FROM articles WHERE {$cat} {$sec_query}AND Date BETWEEN NOW() - INTERVAL {$t} DAY AND NOW() ORDER BY Date DESC";
        $result = $conn->query($mysql_query);
        //echo "SELECT * FROM articles WHERE {$cat} AND Date BETWEEN NOW() - INTERVAL {$t} DAY AND NOW() ORDER BY Date DESC";
        if($result->num_rows > 0){
            //LENGTH MAXIMUM!
            $out = format($result);
        } else {
            $out = "<p>No results found.</p>";
        }
    }
    $conn->close();
} else {
    $out = "<p>No search query.</p>";
    $query = "";
}

function excerpt($content,$numberOfWords){     
    $contentWords = substr_count($content," ") + 1;
    $words = explode(" ",$content,($numberOfWords+1));
    if( $contentWords > $numberOfWords ){
        $words[count($words) - 1] = '...';
    }
    $excerpt = join(" ",$words);
    return $excerpt;
}

function format($result){
    $sections = array("News","Editorial","Opinions","Features","Arts","Sports");
    $out = "";
    while($post = $result->fetch_assoc()){
        $date = date_create($post["Date"]);
        $dateString = date_format($date,"F d, Y");
        $link = "pictures/placeholders/" . $post["Section"] . ".jpg";

        if($post["Image"] == 1){
            $link = "pictures/articles/" . $post["ID"] . ".jpg";
            if(!file_exists($link)){
                $link = "pictures/placeholders/" . $post["Section"] . ".jpg";
            }
        };

        $author = $post["Author"];
        $id = $post["ID"];
        $title = $post["Title"];
        $section = $post["Section"];
        $article_link = "/article.php?id={$id}";

        $first = true;

        if($first){
            $first = false;
        } else {
            $out .= "<div class = \"line_2\"></div>";
        }


        $pos = array_search($section,$sections) +1;
        //get article text
        $content = strip_tags(file_get_contents("articles/{$id}.html"));
        $intro = excerpt($content,70);

        $authorLink = str_replace(" ", "+",$author)."&type=author&section=all&age=all";

        $out .=  "<article class=\"post_type_6\">
							<div class=\"feature\">
								<div class=\"image\" style=\"height: 98px;overflow: hidden;width: 150px;\">
									<a href=\"{$article_link}\"><img src=\"{$link}\" alt=\"Article Image\"><span class=\"hover\"></span></a>
								</div>
							</div>

							<div class=\"content\">
								<div class=\"info\">
									<div class=\"tags\"><a class=\"{$section}\" href=\"/section.php?cat={$pos}\">{$section}</a></div>
									<div class=\"author\">by <a href=\"/search.php?query={$authorLink}\">{$author}</a></div>
									<div class=\"date\">{$dateString}</div>
								</div>

								<div class=\"title\">
									<a href=\"$article_link\">{$title}</a>
								</div>

								<div class=\"text\" style=\"height:57px;\">
									<p>{$intro}</p>
								</div>
							</div>
						</article>";
    }
    return $out;
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>The Lawrence</title>
        <meta http-equiv="Pragma" content="no-cache">  
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="icon" href="/favicon.ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta id="section" content = "Search">
        <!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

        <link rel="stylesheet" href="layout/style.css" type="text/css">

        <script type="text/javascript" src="layout/js/jquery.js"></script>
        <script type="text/javascript" src="layout/js/plugins.js"></script>

        <script type="text/javascript" src="layout/js/main.js"></script>
        <!-- DEBUGGING -->
        <?php echo "<script>console.log( 'Query: " . $mysql_query . "' );</script>"; ?>
        <?php echo "<script>
            function last_state(){
                jQuery(\"#type_select\").val(\"{$type}\");
                jQuery(\"#section_select\").val(\"{$sec}\");
                jQuery(\"#age_select\").val(\"{$age}\");
            }
            </script>"; ?>
    </head>

    <body class="sticky_footer" onload="last_state();">
        <div class="wrapper">
            <!-- HEADER BEGIN -->
            <?php include 'header.php'; ?>
            <!-- HEADER END -->

            <!-- CONTENT BEGIN -->
            <div id="content" class="">
                <div class="inner">
                    <div class="block_general_title_1">
                        <h1>Search</h1>
                    </div>

                    <div class="main_content">
                        <div class="block_search_page">
                            <div class="form">
                                <form action="search.php" method="get">
                                    <?php echo "<div class=\"field\"><input type=\"text\" value=\"{$query}\" name=\"query\"></div>" ?>
                                    <div class="styled-select">
                                        <select name="type" id="type_select" style="width:110px;">
                                            <option value="title">Title</option>
                                            <option value="content">Content</option>
                                            <option value="author">Author</option>
                                            <option value="all">Keyword</option>
                                        </select>
                                    </div>

                                    <div class="styled-select">
                                        <select name="section" id="section_select" style="width:110px;">
                                            <option value="all">All</option>
                                            <option value="news">News</option>
                                            <option value="editorial">Editorial</option>
                                            <option value="opinions">Opinions</option>
                                            <option value="features">Features</option>
                                            <option value="arts">Arts</option>
                                            <option value="sports">Sports</option>
                                        </select>
                                    </div>

                                    <div class="styled-select" style="width:110px;">
                                        <select name="age" id="age_select" style="width:120px;">
                                            <option value="all">All</option>
                                            <option value="week">Last Week</option>
                                            <option value="month">Last Month</option>
                                            <option value="year">Last Year</option>
                                        </select>                                       
                                    </div>
                                    <div><input type="submit" value="Search!" class="search_button"></div>    
                                </form>
                            </div>
                        </div>

                        <div class="block_posts type_6">
                            <?php echo $out; ?>
                        </div>

                        <div class="separator" style="height:43px;"></div>
                    </div>
                    <div class="clearboth"></div>
                    <!-- CONTENT END -->

                </div>
                <!-- FOOTER BEGIN -->
                <?php include 'footer.php'; ?>
                <!-- FOOTER END -->
            </div>
        </div>
    </body>
</html>