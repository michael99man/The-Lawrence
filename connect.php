<?php
/* Database config */

$db_host		= 'localhost';
$db_user		= 'thelawre_reader';
$db_pass		= 'readerSQL';
$db_database		= 'thelawre_TheLawrence';

/* End config */


$conn = new mysqli($db_host, $db_user, $db_pass, $db_database);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    echo "Uh oh";
    die("Connection failed: " . $conn->connect_error);
} 
?>