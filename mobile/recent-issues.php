<?php
error_reporting(-1);
$files = glob($_SERVER['DOCUMENT_ROOT']."/pictures/thumbnails/*.jpeg");
$filenames = array_values($files);

foreach($filenames as $k=>$name){
    $n = basename($name,".jpeg");
    $date = DateTime::createFromFormat("mdY",$n);
    $d = date_format($date, "M j, Y");

    
    $filenames[$k] = array(
        "name" => $n,
        "date" => $d,
    );
}

usort($filenames,"sortFunction");

function sortFunction( $a, $b ) {
    return strtotime($b["date"]) - strtotime($a["date"]);
}
usort($filenames, "sortFunction");

$data = "";
foreach($filenames as &$arr){
    $data .= "<div class='issue'>
                        <h3 class='issue-date'>{$arr["date"]}</h3>
                        <a href='/pictures/recent-issues/{$arr["name"]}.pdf'><img class='thumbnail' src='/pictures/thumbnails/{$arr["name"]}.jpeg'></a>
                    </div>";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>The Lawrence - Recent Issues</title>

        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="icon" href="/favicon.ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta id="section" content="Recent Issues">

        <!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

        <link rel="stylesheet" href="layout/css/style.css" type="text/css">
        <link rel="stylesheet" href="layout/css/style2.css" type="text/css">
        <script type="text/javascript" src="layout/js/jquery.js"></script>
        <script type="text/javascript" src="layout/js/plugins.js"></script>
        <script type="text/javascript" src="layout/js/main.js"></script>
        
        <style>

            .title{
                display:block;
                font-family: 'Montserrat', Helvetica, Arial, sans-serif;
                font-weight: 600;
                text-align: center;
                font-size: 20px;
            }
            
            .issues{
                padding-top: 20px;
            }
            .issues .issue {
                width: 40%;
                display: -moz-inline-stack;
                display: inline-block;
                padding: 0 0 9% 6.7%;
            }

            .issue-date{
                width: 300px;
                margin: 0 auto 0 auto;
                padding-bottom: 12px;
                font-family: 'Montserrat', Helvetica, Arial, sans-serif;
            }

            .issues .issue .thumbnail {
                margin: 0 auto;
                display: block;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                width: 100%;
            }
        </style>

    </head>

    <body class="sticky_footer">
        <div class="wrapper">
            <!-- HEADER BEGIN -->
                <?php include 'header.php' ?>
            <!-- HEADER END -->

            <!-- CONTENT BEGIN -->
            <div id="content" class="">
                <div style="width:100%;" class="issues">
                    <h1 class="title">Recent Issues</h1>
                    <?php echo $data;?>
                </div>
            </div>
            <!-- CONTENT END -->

            <!-- FOOTER BEGIN -->
                <?php include 'footer.php' ?>
            <!-- FOOTER END -->
        </div>
    </body>

</html>