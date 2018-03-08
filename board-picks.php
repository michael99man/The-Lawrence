<?php
header('Content-type: text/html; charset=utf-8');
	    ini_set('default_charset', 'utf-8');
        require "connect.php";
        $result = $conn->query("SELECT * FROM board_picks ORDER BY Date DESC");

        $out = "";
        while($post = $result->fetch_assoc()){
            //$out .= ($post["Title"] . "\n");
            
            
            $date = date_create($post["Date"]);
            $dateString = date_format($date,"F d, Y");
            
            $link = "pictures/board-picks/{$post["ID"]}.jpg";

            $title = $post["Title"];
            
            
            $out .= "<article class=\"board-picks\">
								
								<div class=\"content\">
									<div class=\"info\">
										<div class=\"date\">{$dateString}</div>
									</div>
									
									<div class=\"title\">
										<h2 class=\"picks\">{$title}</h2>
									</div>
                                <div class=\"board-pic\">
								    <img src=\"{$link}\">    
								</div>
									<div class=\"line_1\" style=\"width:100%; margin-top:20px;margin-bottom:20px;\"></div>
								</div>
            </article>";
                            
        }
        $conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>The Lawrence - Board Picks</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="icon" href="/favicon.ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta id="section" content="Board Picks">

        <!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

        <link rel="stylesheet" href="/layout/style.css" type="text/css">

        <script type="text/javascript" src="/layout/js/jquery.js"></script>
        <script type="text/javascript" src="/layout/js/plugins.js"></script>
        <script type="text/javascript" src="/layout/js/main.js"></script>
        
        <style type="text/css">
        
            .board-picks{
                width:700px;
                margin: 0px auto;
            }
            
            .board-pic{
                width: 700px;
            }
            
            .board-pic img{
                width:100%;
            }
            
            .picks{
                font-family:Source Sans Pro;
                font-weight:bold;
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
                <?php echo $out?>
            </div>
            <!-- CONTENT END -->

        <!-- FOOTER BEGIN -->
        <footer>
            <?php include 'footer.php' ?>
        </footer>
        <!-- FOOTER END -->
        </div>
    </body>

</html>