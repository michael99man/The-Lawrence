<?php
header('Content-type: text/html; charset=utf-8');
$val = $_GET["cat"];
$description = "";
switch($val){
    case 1: 
        $name = "news";
        //$description = "No description necessary";
        break;
    case 2: 
        $name = "editorial";
        //$description = "The words of the board";
        break;
    case 3: 
        $name = "opinions";
        //$description = "Oh is that a section?";
        break;
    case 4: 
        $name = "features";
        //$description = "the reason people read <b>the Lawrence</b>";
        break;
    case 5: 
        $name = "arts";
        //$description = "\"Arts\"";
        break;
    case 6: 
        $name = "sports";
        //$description = "Athletic stuff";
        break;
    case 7:
        $name = "nation & world";
        break;
    default:
        header('This is not the page you are looking for', true, 404);
        header("Location: http://thelawrence.org/404.html");
        exit();
}
?>



<!DOCTYPE html>
<html>

    <head>
        <title>The Lawrence - <?php echo ucfirst($name)?></title>

        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="icon" href="/favicon.ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

        <link rel="stylesheet" href="layout/css/style.css" type="text/css">
        <link rel="stylesheet" href="layout/css/style2.css" type="text/css">
        <?php echo "<meta id=\"section\" content = \"{$name}\">"?>
        <script type="text/javascript" src="layout/js/jquery.js"></script>
        <script type="text/javascript" src="layout/js/plugins.js"></script>

        <script type="text/javascript" src="layout/js/main.js"></script>
        <style type="text/css">
            .post-container{
                padding-top: 3vw;
                padding-bottom: 3vw;
                border-top: 1px solid #d3d3d3;
                border-bottom: 1px solid #d3d3d3;
                height: 26vw;
            }

            .post-text{
                display: inline-block;
                height: 100%;
                float: left;
                width: 48vw;
                position: relative;
            }

            .post-pic{
                height: 100%;
                width: 30vw;
                float: right;
                display: inline-block;
                overflow: hidden;
                background-position: center center;
                background-size: cover;
            }

            .article-title{
                display: block;
            }

            .article-author{
                display: block;
            }

            .article-desc{
                display:block;
                margin-top:0.8rem;
                max-height: 9vh;
                overflow: hidden;
            }

            .desc-text{
                font-size: 12px;
                max-height: 100%;
                padding-bottom: 0;
                position: absolute;
                bottom: 0;
                color: black;
                font-style: italic;
            }

            .posts {
                height: auto !important;
            }
        </style>

    </head>

    <body class="sticky_footer">
        <div class="wrapper">
            <!-- HEADER BEGIN -->
            <?php include 'header.php'; ?>
            <!-- HEADER END -->

            <!-- CONTENT BEGIN -->
            <div id="content" class="">
                <div class="inner">
                    <div class="block_posts">
                        <div class="posts">
                            <!-- FIRST -->
                            <div class="section-container">
                                <!-- each section has a section title, then a post with picture -->
                                <!-- inspired by bbc.co.uk -->

                                    <div class="title-container" style="text-align:center;">
                                        <a class="section-title">
                                            <?php echo "<span class='{$name}'>" . strtoupper($name) . "</span>";?>
                                        </a>
                                    </div>

                                        <div class="block_posts type_5 type_sort general_not_loaded">
                                            <ul class="posts">

                                            </ul>

                                            <div class="controls">
                                                <a href="#" id="button_load_more" data-target=".block_posts.type_sort .posts" class="load_more_1"><span>Load more posts</span></a>
                                            </div>
                                        </div>
                                    <!--

<div class="post-text">
<div class="article-title">
<a class="title">
Doge learns HTML
</a>
</div>

<div class="article-author">
<a class="link-article">
<span class="tag news">Dogey Doge '17</span>
</a>
</div>

<div class="article-desc">
<p class="desc-text">
Doge learns html what a cool doge he probably likes to doge alot. Doge learns html what a cool doge.
</p>
</div>
</div>

<div class="post-pic">
<img src="/images/doge.jpg" height="100%">

</div>
</li>

<li class="post-container">

<div class="post-text">
<div class="article-title">
<a class="title">
Doge learns HTML
</a>
</div>

<div class="article-author">
<a class="link-article">
<span class="tag news">Dogey Doge '17</span>
</a>
</div>

<div class="article-desc">
<p class="desc-text">
Doge learns html what a cool doge he probably likes to doge alot. Doge learns html what a cool doge.
</p>
</div>
</div>

<div class="post-pic">
<img src="/images/doge.jpg" height="100%">

</div>
</li>-->
                            </div>
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