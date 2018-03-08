<?php
require "connect.php";
$maxQuery = "SELECT MAX(CAST(ID as SIGNED)) from articles;";
$result = $conn->query($maxQuery);
$post = $result->fetch_assoc();
$max = $post["MAX(CAST(ID as SIGNED))"];
$id = rand(1,$max);
header("Location: http://www.thelawrence.org/article.php?id={$id}");
?>