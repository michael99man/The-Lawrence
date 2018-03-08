<?php
header('Content-type: text/html; charset=utf-8');
ini_set('default_charset', 'utf-8');
require $_SERVER['DOCUMENT_ROOT'] . "/connect.php";
$section = $conn->real_escape_string($_GET["section"]);
$amount =  $conn->real_escape_string($_GET["amount"]);
//offset
if($section == "nation"){
    $section = "Nation & World";
}
$result = $conn->query("SELECT * FROM articles WHERE section = \"{$section}\" ORDER BY Date DESC LIMIT 9 OFFSET " . ($amount - 9));
//ORDER BY DATE
//AMOUNT!!!

$out = "";
while($post = $result->fetch_assoc()){
    //$out .= ($post["Title"] . "\n");


    $date = date_create($post["Date"]);
    $dateString = date_format($date,"F d, Y");

    $placeholderLink = $post["Section"];

    if($section === "Nation & World"){
        $placeholderLink = "News";
    }

    $link = "/pictures/placeholders/{$placeholderLink}.jpg";
    if($post["Image"] == 1){
        $link = "/pictures/articles/" . $post["ID"] . ".jpg";
    };

    $author = $post["Author"];
    $title = $post["Title"];

    $out .= "<li class='post-container'><div class='post-text'><div class='article-title'>
<a class='title' href='article.php?id={$post["ID"]}'>
{$title}
</a>
</div>

<div class='article-author'>
<a class='link-article'>
<span class='tag {$section}'>{$author}</span>
</a>
</div>

<div class='article-desc'>
<p class='desc-text'>{$dateString}</p>
</div>
</div>

<div class='post-pic' style='background-image:url({$link});'>
</div></li>";
}
echo $out;
$conn->close();
?>							