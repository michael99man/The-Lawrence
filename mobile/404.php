<?php
require $_SERVER['DOCUMENT_ROOT'] . "/connect.php";
$request = $_SERVER['REQUEST_URI'];
$offset = strrpos($request,"/");
$request = substr($request,$offset+1);
$parsed = str_replace("-"," ",$request);
if($end = strrpos($parsed,"?utm_content")){
    $parsed = substr($parsed,0,$end);
}
if($parsed != $request){
    $parsed = $conn->real_escape_string($parsed);
    $result = $conn->query("SELECT * FROM articles WHERE Title LIKE '%{$parsed}%'");
    $result = $result->fetch_assoc();
    if(isset($result["ID"])){
        header("Location: http://www.thelawrence.org/article.php?id={$result["ID"]}");
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
<title>The Lawrence - Error 404</title>

<meta name="keywords" content="">
<meta name="description" content="">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta id="section" content="404">
    
<!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

<link rel="stylesheet" href="/mobile/layout/css/style.css" type="text/css">
    <link rel="stylesheet" href="/mobile/layout/css/style2.css" type="text/css">

<script type="text/javascript" src="/mobile/layout/js/jquery.js"></script>
<script type="text/javascript" src="/mobile/layout/js/plugins.js"></script>

<script type="text/javascript" src="/mobile/layout/js/main.js"></script>
<link rel="icon" href="/favicon.ico">
</head>

<body class="sticky_footer">
	<div class="wrapper">
		<!-- HEADER BEGIN -->
		<header>
            <?php include 'header.php' ?>
		</header>
		<!-- HEADER END -->
		
		<!-- CONTENT BEGIN -->
		<div id="content" class="">
			<div class="inner">
				<div class="block_404">
					<h1>404</h1>
					<h2>Sorry, but the page you are looking for can not be found.</h2>
                    <h2>Please contact Web Editor at mman17@lawrenceville.org to report any errors.</h2>
					<!--<a class="hover404">This is because of one of two reasons<img class="img404" src="/images/404.png"></a>-->      
				</div>
			</div>
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