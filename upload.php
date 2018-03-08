<?php
ini_set('default_charset', 'utf-8');
header('Content-type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'thelawre_upload', 'mmupload', 'thelawre_TheLawrence');
$conn->set_charset("utf8");

if(isset($_POST["submit"])) {
    if(isset($_POST["title"]) && isset($_POST["article_text"])){
        $article_text = "<meta charset=\"utf-8\"/>" . nl2p($_POST["article_text"]);
        if($_POST["password"] == "mmupload"){
            echo $article_text;
            if (isset($article_text)){
                $result = $conn->query("SELECT MAX(CAST(ID as UNSIGNED)) FROM articles");
                $data = $result->fetch_assoc();
                $id = $data["MAX(CAST(ID as UNSIGNED))"]+1;
                echo "Creating new article with ID: {$id}<br>";

                $target_html = "articles/{$id}.html";
                $title = $conn->real_escape_string($_POST["title"]); 
                $author = $conn->real_escape_string($_POST["author"]);
                $date = date_create($_POST["date"]);
                $section = $conn->real_escape_string($_POST["section"]);
                $img = 0;
                $caption = "";
                if(file_exists($_FILES['uploadJPG']['tmp_name']) || is_uploaded_file($_FILES['uploadJPG']['tmp_name'])){
                    $img = 1;
                    echo "Uploading JPG<br>";
                    $target_jpg = "pictures/articles/{$id}.jpg";
                    if(move_uploaded_file($_FILES["uploadJPG"]["tmp_name"], $target_jpg)){
                        echo "Uploaded JPG to {$target_jpg}<br>";
                        $caption = $conn->real_escape_string($_POST["caption"]);
                    }
                }
                $htmlfile = fopen($target_html,"w") or die("Error creating file!");
                fwrite($htmlfile,$article_text);
                echo "Created new HTML file in {$target_html}<br>";
                $query = "INSERT INTO articles (ID,Title,Author,Date,Section,Image,Caption)
                      VALUES('{$id}','{$title}','{$author}','{$date->format('Y-m-d')}','{$section}','{$img}','{$caption}')";
                echo $query ."<br>";
                $r = $conn->query($query);
                if($r){
                    echo "Successfully inserted a new article.<br>";
                } else {
                    echo "Failed to insert new article.<br>";
                }
            } else {
                echo "No HTML file found.<br>";
            }
        } else {
            echo "Wrong password.";
            
        }
    } else {
       echo "Title and/or article text blank.";
    } 
}  

function nl2p($string) {

    $string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
    return '<p>'.preg_replace("/\n/i", "</p>\n<p>", trim($string)).'</p>';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>The Lawrence - Upload</title>
        <link rel="icon" href="/favicon.ico">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <style type="text/css">
            input{
                margin-bottom: 10px;
            }
            textarea{
                margin-bottom: 10px;
                width: 500px;
                height: 300px;
            }
        </style>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    </head>
    <body>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <textarea name="article_text" id="article_text"></textarea><br>
            Select JPG to upload: <input type="file" name="uploadJPG" id = "uploadJPG"><br>
            Photo Caption: <input type="text" name="caption"><br>
            Title: <input type="text" name = "title"><br>
            Author: <input type="text" name = "author"><br>
            Date: <input type="date" name = "date" value="<?php echo date('Y-m-d'); ?>"><br>
            Section: <input type="text" name = "section" value ="News"><br>
            Password: <input type="password" name="password" value =""><br>
            <input type="submit" value="Upload" name="submit">
        </form>
    </body>
</html>