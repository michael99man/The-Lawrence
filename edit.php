<?php
ini_set('default_charset', 'utf-8');
header('Content-type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$valid_passwords = array ("mman" => "mmedit","wmadonia"=>"wmedit","jwellemeyer"=>"jwedit","asukach"=>"asedit","kshao"=>"ksedit");
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Not authorized");
}
$msg = "";

if(isset($_POST["article"]) && !empty($_POST["article"])){
    //Posting a new article
    
    $article = $_POST["article"];
    $artID = strval($_POST["artID"]);
    $path = "articles/{$artID}.html";
        
    $success = file_put_contents($path,$article);
    if(!$success){
        $msg = "Failed to upload to {$path}.";
    } else {
        $msg = "Successfully uploaded {$success} bytes to {$path}.";
    }
    $mode = "select";
} else if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
    //Loading an old article
    
    
    $id = strval($_POST["ID"]);
    $mode = "edit";
    $link = "articles/{$id}.html/";
    
    $content = file_get_contents("articles/{$id}.html");
    
    if(!$content){
        $mode = "select";
        $msg = "<h3>{$link} does not exist.</h3>";
    } else {
        //do something
    }
} else {
    //First time loading
    $mode = "select";   
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
        <meta id="section" content = "Edit">
        <!--[if lt IE 9]>
<script type="text/javascript" src="layout/plugins/html5.js"></script>
<![endif]-->

        <link rel="stylesheet" href="layout/style.css" type="text/css">

        <script type="text/javascript" src="layout/js/jquery.js"></script>
        <script type="text/javascript" src="layout/js/plugins.js"></script>

        <script type="text/javascript" src="layout/js/main.js"></script>

        <script type="text/javascript" src="layout/plugins/markitup/jquery.markitup.js"></script>

        <script type="text/javascript" src="layout/plugins/markitup/sets/default/set.js"></script>

        <link rel="stylesheet" type="text/css" href="layout/plugins/markitup/skins/markitup/style.css" />
        <link rel="stylesheet" type="text/css" href="layout/plugins/markitup/sets/default/style.css" />

        <script type="text/javascript" >
            $(document).ready(function() {

                var mode = "<?php echo $mode; ?>";
                console.log("Mode: " + mode);

                if(mode == "edit"){
                    $("#editField").markItUp(mySettings);
                }
            });

            function submit(){
                console.log("Submitting...");
                var content = $("#editField").val();
                console.log(content);
            }
        </script>

        <style>
            #submitEdits{
                width: 200px;
                height: 48px;
                line-height: 37px;
                margin: 0px 0px;
                display: block;
                border: 3px solid #4CAF50;
                background: white;
                color: #4e4e4e;
                font-weight: bold;
                text-transform: uppercase;
                text-align: center;
            }
            
            #submitEdits:hover{
                background-color: #4CAF50;
                color: white;
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
                    <?php echo "<h1 style=\"padding-bottom:4px;\">Welcome {$user}.</h1>";?>

                    <?php 
                    if($mode == "select"){
                        echo "<br><p>Make a selection below</p><form action='edit.php' method='post'>Article ID:<br>{$msg}<br>
                            <input type='text' name='ID' style='margin-bottom:4px;'><br>
                            <input type='submit' value='Load article'>
                            </form>";
                    } else if($mode == "edit"){
                        echo "<p style='padding-bottom:0px;'>Editing {$id}.html</p><br>";
                        echo "<form action='edit.php' method='post' enctype='multipart/form-data'><textarea id='editField' name='article'>{$content}</textarea><input type='hidden' value='{$id}' name='artID'/><input type='submit' value='Upload' id='submitEdits' name='submit'>";
                    }
                    ?>
                </div>

                <!-- CONTENT END -->

                <!-- FOOTER BEGIN -->
                <?php include 'footer.php'; ?>
                <!-- FOOTER END -->
            </div>
        </div>
    </body>
</html>