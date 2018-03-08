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
<link rel="icon" href="/favicon.ico">
<meta name="keywords" content="">
<meta name="description" content="">
<?php echo "<meta id=\"section\" content = \"{$name}\">"?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
		<?php include 'header.php' ?>
		<!-- HEADER END -->
		
		<!-- CONTENT BEGIN -->
		<div id="content">
			<div class="inner">
				<div class="block_general_title_1">
					<h1><?php echo strtoupper($name)?></h1>
					<?php echo "<h2 class = \"{$name}\">" . strtoupper($description) . "</h2>"?>
				</div>
				
				<div class="main_content">
				
                    <!--PHP-->
					
					<div class="block_posts type_5 type_sort general_not_loaded">
						<div class="posts">
							
						</div>
				        
						<div class="controls">
							<a href="#" id="button_load_more" data-target=".block_posts.type_sort .posts" class="load_more_1"><span>Load more posts</span></a>
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